<?php

// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.cookie_lifetime', 0);
  ini_set('session.gc_maxlifetime', 3600);
  session_start();
}

// Include necessary files for database connection
include_once('php7/config.php');
include_once('functions.php');
include_once('functions_userObj.php');

// Get user object from session
$userObject = isset($_SESSION['userObject']) ? $_SESSION['userObject'] : null;

/**
 * Audio Progress Functions
 * Handles tracking of user audio completion progress
 */

/**
 * Get all completed audio for a user in a category
 * @param int $user_id
 * @param string $category
 * @return array Array of completed audio numbers
 */
function getAudioProgress($user_id, $category)
{
  $query = "SELECT audio_number FROM audio_progress 
              WHERE user_id = '$user_id' AND category = '$category' AND completed = 1";
  $result = mysql_query($query);

  $completed = array();
  if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
      $completed[] = $row['audio_number'];
    }
  }
  return $completed;
}

/**
 * Mark an audio as completed for a user
 * @param int $user_id
 * @param string $category
 * @param int $audio_number
 * @return bool Success status
 */
function markAudioCompleted($user_id, $category, $audio_number)
{
  $query = "INSERT INTO audio_progress (user_id, category, audio_number, completed) 
              VALUES ('$user_id', '$category', '$audio_number', 1)
              ON DUPLICATE KEY UPDATE completed = 1";

  $result = mysql_query($query);
  return $result !== false;
}

/**
 * Mark an audio as incomplete for a user
 * @param int $user_id
 * @param string $category
 * @param int $audio_number
 * @return bool Success status
 */
function unmarkAudioCompleted($user_id, $category, $audio_number)
{
  $query = "UPDATE audio_progress 
              SET completed = 0 
              WHERE user_id = '$user_id' AND category = '$category' AND audio_number = '$audio_number'";

  $result = mysql_query($query);
  return $result !== false;
}

/**
 * Get completion statistics for a user
 * @param int $user_id
 * @return array Array with category => count of completed audios
 */
function getAudioStats($user_id)
{
  $query = "SELECT category, COUNT(*) as completed_count 
              FROM audio_progress 
              WHERE user_id = '$user_id' AND completed = 1 
              GROUP BY category";

  $result = mysql_query($query);
  $stats = array();

  if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
      $stats[$row['category']] = $row['completed_count'];
    }
  }
  return $stats;
}

/**
 * Handle AJAX request to mark audio
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'toggleAudio') {
  header('Content-Type: application/json');

  // DEBUG: Log the incoming request
  $debug = [
    'timestamp' => date('Y-m-d H:i:s'),
    'post_data' => $_POST,
    'session_data' => $_SESSION ? 'Session exists' : 'No session',
    'userObject_exists' => isset($userObject) ? 'Yes' : 'No',
    'userObject_value' => isset($userObject) ? ($userObject ? 'Truthy' : 'Falsy (0 or empty)') : 'Not set'
  ];
  error_log('AudioProgress AJAX Request: ' . json_encode($debug));

  if (!isset($userObject) || !$userObject) {
    error_log('AudioProgress: User not logged in - userObject: ' . var_export($userObject, true));
    echo json_encode(['success' => false, 'message' => 'User not logged in', 'debug' => $debug]);
    exit;
  }

  $user_id = $userObject['id'];
  $category = isset($_POST['category']) ? $_POST['category'] : '';
  $audio_number = isset($_POST['audio_number']) ? intval($_POST['audio_number']) : 0;
  $completed = isset($_POST['completed']) ? intval($_POST['completed']) : 0;

  error_log("AudioProgress: user_id=$user_id, category=$category, audio_number=$audio_number, completed=$completed");

  if (!$category || !$audio_number) {
    error_log('AudioProgress: Invalid parameters - category: ' . var_export($category, true) . ', audio_number: ' . var_export($audio_number, true));
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
  }

  if ($completed) {
    error_log("AudioProgress: Marking audio as completed - user_id=$user_id, category=$category, audio_number=$audio_number");
    $success = markAudioCompleted($user_id, $category, $audio_number);
    error_log("AudioProgress: markAudioCompleted result: " . ($success ? 'success' : 'failed'));
  } else {
    error_log("AudioProgress: Marking audio as incomplete - user_id=$user_id, category=$category, audio_number=$audio_number");
    $success = unmarkAudioCompleted($user_id, $category, $audio_number);
    error_log("AudioProgress: unmarkAudioCompleted result: " . ($success ? 'success' : 'failed'));
  }

  if (!$success) {
    $last_error = mysql_error();
    error_log("AudioProgress: Database error: " . $last_error);
    echo json_encode(['success' => $success, 'error' => $last_error]);
  } else {
    echo json_encode(['success' => $success]);
  }
  exit;
}

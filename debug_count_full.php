<?php
include_once('functions.php');
include_once('functions_levels.php');
include_once('functions_userObj.php');

// Get the analysis
$analysis = analyzeWordDatabase();

echo "<h1>Database Word/Sentence Analysis</h1>";
echo "<h2>Total Records in Database: " . number_format($analysis['total_records']) . "</h2>";

echo "<h3>Breakdown by Level:</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Level</th><th>Name</th><th>Type</th><th>Records</th><th>Unique English</th><th>Has Hungarian</th></tr>";

$totalWords = 0;
$totalSentences = 0;
$totalOther = 0;

foreach ($analysis['levels'] as $levelData) {
  echo "<tr>";
  echo "<td>" . $levelData['level'] . "</td>";
  echo "<td>" . htmlspecialchars($levelData['name']) . "</td>";
  echo "<td>" . $levelData['type_label'] . "</td>";
  echo "<td>" . number_format($levelData['record_count']) . "</td>";
  echo "<td>" . number_format($levelData['unique_english_words']) . "</td>";
  echo "<td>" . number_format($levelData['has_hungarian']) . "</td>";
  echo "</tr>";

  if ($levelData['type'] == 1) {
    $totalWords += $levelData['has_hungarian'];
  } else if ($levelData['type'] == 2) {
    $totalSentences += $levelData['has_hungarian'];
  } else {
    $totalOther += $levelData['has_hungarian'];
  }
}

echo "</table>";

echo "<h3>Summary:</h3>";
echo "<p><strong>Words (Type 1):</strong> " . number_format($totalWords) . "</p>";
echo "<p><strong>Sentences (Type 2):</strong> " . number_format($totalSentences) . "</p>";
echo "<p><strong>Other (Type 3/Unknown):</strong> " . number_format($totalOther) . "</p>";
echo "<p><strong>Records with no level/level 0:</strong> " . number_format($analysis['no_level_count']) . "</p>";
echo "<p><strong>Incomplete English-Hungarian pairs:</strong> " . number_format($analysis['incomplete_pairs']) . "</p>";

echo "<h3>Current Counter Results:</h3>";
$currentCounts = getTotalWordAndSentenceCounts();
echo "<p><strong>Current Word Count:</strong> " . number_format($currentCounts['words']) . "</p>";
echo "<p><strong>Current Sentence Count:</strong> " . number_format($currentCounts['sentences']) . "</p>";

// Let's also check what levels are being considered
$list = getLevelList('angol');
$wordLevels = array();
$sentenceLevels = array();

foreach ($list as $key => $value) {
  if ($value[1] == 1 && $key != 0) {
    $wordLevels[] = $key;
  } else if ($value[1] == 2 && $key != 0) {
    $sentenceLevels[] = $key;
  }
}

echo "<h3>Levels being counted:</h3>";
echo "<p><strong>Word Levels (Type 1):</strong> " . implode(", ", $wordLevels) . "</p>";
echo "<p><strong>Sentence Levels (Type 2):</strong> " . implode(", ", $sentenceLevels) . "</p>";

// Additional analysis - check all language combinations
echo "<h3>Language Combination Analysis:</h3>";

$langQueries = array(
  'English-Hungarian' => "SELECT count(*) FROM words WHERE word_angol IS NOT NULL AND word_angol != '' AND word_angol != '...' AND word_hun IS NOT NULL AND word_hun != '' AND word_hun != '...'",
  'English-Spanish' => "SELECT count(*) FROM words WHERE word_angol IS NOT NULL AND word_angol != '' AND word_angol != '...' AND word_spanyol IS NOT NULL AND word_spanyol != '' AND word_spanyol != '...'",
  'Hungarian-Spanish' => "SELECT count(*) FROM words WHERE word_hun IS NOT NULL AND word_hun != '' AND word_hun != '...' AND word_spanyol IS NOT NULL AND word_spanyol != '' AND word_spanyol != '...'",
  'English only' => "SELECT count(*) FROM words WHERE word_angol IS NOT NULL AND word_angol != '' AND word_angol != '...' AND (word_hun IS NULL OR word_hun = '' OR word_hun = '...') AND (word_spanyol IS NULL OR word_spanyol = '' OR word_spanyol = '...')",
  'Hungarian only' => "SELECT count(*) FROM words WHERE word_hun IS NOT NULL AND word_hun != '' AND word_hun != '...' AND (word_angol IS NULL OR word_angol = '' OR word_angol = '...') AND (word_spanyol IS NULL OR word_spanyol = '' OR word_spanyol = '...')",
  'Spanish only' => "SELECT count(*) FROM words WHERE word_spanyol IS NOT NULL AND word_spanyol != '' AND word_spanyol != '...' AND (word_angol IS NULL OR word_angol = '' OR word_angol = '...') AND (word_hun IS NULL OR word_hun = '' OR word_hun = '...')",
  'All three languages' => "SELECT count(*) FROM words WHERE word_angol IS NOT NULL AND word_angol != '' AND word_angol != '...' AND word_hun IS NOT NULL AND word_hun != '' AND word_hun != '...' AND word_spanyol IS NOT NULL AND word_spanyol != '' AND word_spanyol != '...'"
);

foreach ($langQueries as $description => $query) {
  $result = mysql_query($query);
  if ($result) {
    $row = mysql_fetch_row($result);
    echo "<p><strong>$description:</strong> " . number_format($row[0]) . "</p>";
  }
}

// Check what the issue might be with our counting by showing actual counts per level
echo "<h3>Detailed Count Verification:</h3>";

echo "<h4>Word Levels (Type 1) detailed count:</h4>";
$totalWordCheck = 0;
foreach ($wordLevels as $level) {
  $query = "SELECT count(distinct w.word_angol) FROM words w WHERE w.level_angol = $level AND w.word_angol IS NOT NULL AND w.word_angol != '' AND w.word_angol != '...' AND w.word_hun IS NOT NULL AND w.word_hun != '' AND w.word_hun != '...'";
  $result = mysql_query($query);
  if ($result) {
    $row = mysql_fetch_row($result);
    echo "<p>Level $level: " . number_format($row[0]) . "</p>";
    $totalWordCheck += $row[0];
  }
}
echo "<p><strong>Total Words Check:</strong> " . number_format($totalWordCheck) . "</p>";

echo "<h4>Sentence Levels (Type 2) detailed count:</h4>";
$totalSentenceCheck = 0;
foreach ($sentenceLevels as $level) {
  $query = "SELECT count(distinct w.word_angol) FROM words w WHERE w.level_angol = $level AND w.word_angol IS NOT NULL AND w.word_angol != '' AND w.word_angol != '...' AND w.word_hun IS NOT NULL AND w.word_hun != '' AND w.word_hun != '...'";
  $result = mysql_query($query);
  if ($result) {
    $row = mysql_fetch_row($result);
    echo "<p>Level $level: " . number_format($row[0]) . "</p>";
    $totalSentenceCheck += $row[0];
  }
}
echo "<p><strong>Total Sentences Check:</strong> " . number_format($totalSentenceCheck) . "</p>";

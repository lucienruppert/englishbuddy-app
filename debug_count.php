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

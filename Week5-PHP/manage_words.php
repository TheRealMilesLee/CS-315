<?php
/**
 * @description A program to manage the word list for the GRE quiz
 * This program has two functions
 * 1. Add a word
 * 2. Delete a word from the current list
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 0.0.1 Alpha
 */
define('DEFINITION_FILENAME', 'results.txt');
/**
 * @param array $paired_array is the array to output
 */
function output_to_file(array $paired_array): void
{
  for ($index = 0; $index < count($paired_array); $index++)
  {
    $words_total = $paired_array[$index]['word'];
    $part_of_speech_total = $paired_array[$index]['part'];
    $definition_total = $paired_array[$index]['definition'];
    $result = "$words_total\t$part_of_speech_total\t$definition_total\n";
    file_put_contents(DEFINITION_FILENAME, $result, LOCK_EX | FILE_APPEND);
  }
}

function search_word($array, $word_to_search): int
{
  $index = 0;
  $found = false;
  $position = -1;
  while ($index < count($array) && !$found)
  {
    if ($array[$index]['word'] == $word_to_search)
    {
      $position = $index;
      $found = true;
    }
    $index++;
  }
  unset($index);
  return $position;
}

/**
 * This function is to read the file and make a word-speech and definition
 * pair.
 * @param $file_to_load
 * @return array is the key-value paired word list
 */
function getPaired_array($file_to_load): array
{
  $paired_array = array();
  $total_lines = file($file_to_load, FILE_IGNORE_NEW_LINES);
  ksort($total_lines);

  for ($loop = 0; $loop < count($total_lines); $loop++)
  {
    list($word, $part, $definition) = explode("\t", $total_lines[$loop]);
    $paired_array[] =
      array('word' => $word, 'part' => $part, 'definition' => $definition);
  }
  return $paired_array;
}

/**
 * This function is to delete the word
 * @param $file_to_load
 * @param $delete_word
 */
function delete_word($file_to_load, $delete_word)
{
  $paired_array = getPaired_array($file_to_load);
  $position = search_word($paired_array, $delete_word);
  if ($position > -1)
  {
    unset($paired_array[$position]);
  }
  else
  {
    echo "No entries found! ";
  }
  ksort($paired_array);
  output_to_file($paired_array);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title> Manage Words </title>
  <meta name="author" content="Hengyi Li" />
</head>
<body>
<h1> Word Manager </h1>
<p>
  This is the Zelda's GRE vocabulary manager, choose to add a new word or
  delete a word.
</p>
<h2> Add a new word </h2>
<form method="post" action="manage_words.php">
  <p>
    <label for="new_word"> What's the word? </label>
    <input type='text' id='new_word' name='new_word' required />
  </p>
  <p>
    <label for="speech"> What's the part of speech of the word? </label>
    <select name="speech" id="speech">
      <option value='noun'> noun</option>
      <option value='adjective'> adjective</option>
      <option value='adverb'> adverb</option>
      <option value='verb'> verb</option>
    </select>
  </p>
  <p>
    <label for="def_new_word"> What's the definition of the word? </label>
    <input type='text' id="def_new_word" name="def_new_word" required />
  </p>
  <p>
    <input type='submit' value='Submit Report' name='submit' />
  </p>
</form>
<?php
$paired_array = getPaired_array(DEFINITION_FILENAME);
if ( isset($_POST) && isset($_POST['new_word'])
  && preg_match('|^[A-Za-z]+$|', $_POST['new_word'])
  && isset($_POST['def_new_word'])
  && preg_match('|^[A-Za-z;( -]+|', $_POST['def_new_word']))
{
  $word_new = $_POST['new_word'];
  $part_speech = $_POST['speech'];
  $definition = $_POST['def_new_word'];
  $lowercase_word = strtolower($word_new);
  $position = search_word($paired_array, $word_new);
  if ($position > -1)
  {
    echo 'The word is already exist!';
  }
  else
  {
    $paired_array[] =
      array('word' => $lowercase_word, 'part' => $part_speech, 'definition' => $definition);
    ksort($paired_array);
    var_dump($paired_array);
    output_to_file($paired_array);
  }
}
?>
<h2> Delete a word </h2>
<form method="post" action="manage_words.php">
  <p>
    <label for="del_word"> What's the word? </label>
    <input type='text' id='del_word' name='del_word' required />
  </p>
  <p>
    <input type='submit' value='Delete entry' name='submit_delete_word' />
  </p>
</form>
<?php
if ( isset($_POST) && isset($_POST['del_word'])
  && preg_match('|^[A-Za-z]+$|', $_POST['del_word']))
{
  $deleted_word = $_POST['del_word'];
  delete_word(DEFINITION_FILENAME, $deleted_word);
}
?>
</body>
</html>

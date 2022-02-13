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
 * This function is to read the file and make a word-speech and definition
 * pair.
 * @param $file_to_load is the file to load from disk
 * @return array is the key-value paired word list
 */
function getPaired_array($file_to_load): array
{
  $paired_array = array();
  $total_lines = file($file_to_load, FILE_IGNORE_NEW_LINES);
  for ($loop = 0; $loop < count($total_lines); $loop++)
  {
    list($word, $part, $definition) = explode("\t", $total_lines[$loop]);
    $combined = "$part \t $definition";
    $paired_array[] = array($word => $combined);
  }
  return $paired_array;
}

/**
 * This function is to delete the word
 * @param $file_to_load is the file that comes from disk
 * @param $delete_word is the word that user wants to delete
 */
function delete_word($file_to_load, $delete_word)
{
  $paired_array = getPaired_array($file_to_load);
  unset($paired_array[$delete_word]);
  file_put_contents('filename.txt', print_r($paired_array, true));
}

function validate($file_to_load, $word_new, $input_result)
{
  $paired_array = getPaired_array($file_to_load);
  if (is_numeric(array_search($word_new,$paired_array)))
  {
    echo 'The word is already exist!';
  }
  else
  {
    file_put_contents(DEFINITION_FILENAME, $input_result, LOCK_EX | FILE_APPEND);
  }
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
      <option value='noun'> noun </option>
      <option value='adjective'> adjective </option>
      <option value='adverb'> adverb </option>
      <option value='verb'> verb </option>
    </select>
  </p>
  <p>
    <label for="def_new_word"> What's the definition of the word? </label>
    <input type='text' id="def_new_word" name="def_new_word" required />
  </p>
  <input type='submit' value='Submit Report' name='submit' />
</form>
<?php
if (isset($_POST) && isset($_POST['new_word'])
  && preg_match('|^[A-Za-z]+$|', $_POST['new_word'])
  && isset($_POST['def_new_word'])
  && preg_match('|^[A-Za-z;( -]+|', $_POST['def_new_word'])
  && isset($_POST['speech'])
  && preg_match('|^[a-z]+.$|', $_POST['speech']))
{
  $word_new = $_POST['new_word'];
  $part_speech = $_POST['speech'];
  $definition = $_POST['def_new_word'];
  $input_result = "$word_new \t $part_speech \t $definition \n";
  validate(DEFINITION_FILENAME, $word_new, $input_result);
}
?>
<h2> Delete a word </h2>
<form method="post" action="manage_words.php">
  <p>
    <label for="del_word"> What's the word? </label>
    <input type='text' id='del_word' name='del_word' required />
  </p>
  <input type='submit' value='Delete option' name='submit_delete_word'/>
</form>
<?php
if (isset($_POST) && isset($_POST['del_word'])
  && preg_match('|^[A-Za-z]+$|', $_POST['del_word']))
{
  $deleted_word = $_POST['del_word'];
  delete_word(DEFINITION_FILENAME, $deleted_word);
}
?>
</body>
</html>

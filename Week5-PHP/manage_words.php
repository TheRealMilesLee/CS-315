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
define('DEFINITION_FILENAME', '1.txt');
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
    <input type='text' id="speech" name="speech" required />
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
  $first_time = false;
  $word_new = $_POST['new_word'];
  $part_speech = $_POST['speech'];
  $definition = $_POST['def_new_word'];
  $msg = "$word_new has been added with the part of speech is $part_speech and definition is $definition \n";
  file_put_contents(DEFINITION_FILENAME, $msg, LOCK_EX | FILE_APPEND);
}
?>
<h2> Delete a word </h2>
<form method="post" action="manage_words.php">
  <p>
    What's the word?
    <input type='text' id='del_word' name='del_word' required />
  </p>
</form>
</body>
</html>

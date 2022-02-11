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
const DEFINITION_FILENAME = 'words.txt';
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
<form method="post" action="echo.php">
  <p>
    What's the word?
    <input type='text' id='new_word' name='new_word' required />
  </p>
  <p>
    What's the part of speech of the word?
    <input type='text' id="speech" name="speech" required />
  </p>
  <p>
    What's the definition of the word?
    <input type='text' id="def_new_word" name="def_new_word" required />
  </p>
</form>
<h2> Delete a word </h2>
<form method="post" action="manage_words.php">
  <p>
    What's the word?
    <input type='text' id='new_word' name='new_word' required />
  </p>
</form>
<input type='submit' value='Submit Report' name='submit' />
</body>
</html>

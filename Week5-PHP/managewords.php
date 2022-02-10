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
    <p> This is the Zelda's GRE vocabulary manager, choose to add a new word or delete a word.</p>
    <label>
        <select>
            <option value="default"> Make a selection </option>
            <option value="Add"> Add a new word </option>
            <option value="Delete"> Delete a word </option>
        </select>
    </label>
  </body>
</html>

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
    <h2> Add a new world </h2>
    <form>
        <p>
            The word is <input type="text" id="whattheydid" name="whattheydid" size="32" />
        </p>
        <P>

        </P>

    </form>
    <h2> Delete a word </h2>
    <button id="submit" type="submit">Submit</button>
  </body>
</html>

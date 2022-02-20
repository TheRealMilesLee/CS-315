<?php
  /**
   * @description A program to manage the word list for the GRE quiz
   * This program has two functions
   * 1. Add a word
   * 2. Delete a word from the current list
   * @author Hengyi Li
   * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
   * @version 10.2.13 Release
   */
  define("DEFINITION_FILENAME", "words.txt");
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  function display_entry(array $paired_array) : void
  {
    array_multisort($paired_array, SORT_ASC, SORT_REGULAR);
      for ($index = 0; $index < count($paired_array); $index++)
      {
        if (!array_key_exists($index, $paired_array))
        {
          $index++;
        }
        $words_total = $paired_array[$index]['word'];
        $part_of_speech_total = $paired_array[$index]['part'];
        $definition_total = $paired_array[$index]['definition'];
        $result = "$words_total\t$part_of_speech_total\t$definition_total\n";
?>
        <?= $index, " : ", $result , "<br />"?>
<?php
      }
  }
  /**
   * This function is to output the contents to the file
   * @param array $paired_array is the array to output
   */
  function output_to_file(array $paired_array): void
  {
    // Sort the array in ascending order
    array_multisort($paired_array, SORT_ASC, SORT_REGULAR);
    // cleanup original content for new input
    file_put_contents(DEFINITION_FILENAME, '');
    $index = 0;
    while ($index < count($paired_array))
    {
      // Jump the hole in the array
      if (!array_key_exists($index, $paired_array))
      {
        $index++;
      }
      $words_total = $paired_array[$index]['word'];
      $part_of_speech_total = $paired_array[$index]['part'];
      $definition_total = $paired_array[$index]['definition'];
      $result = "$words_total\t$part_of_speech_total\t$definition_total\n";
      file_put_contents(DEFINITION_FILENAME, $result, LOCK_EX | FILE_APPEND);
      $index++;
    }
    unset($paired_array[$index]);
  }

  /**
   * @param array $array is the array to sort
   * @param string $word_to_search is the word that search in the array
   * @return int is the index of the word
   */
  function search_word(array &$array, string $word_to_search, $part_of_speech): int
  {
    $found = false;
    $index = 0;
    while ($index < count($array) && !$found)
    {
      if (strcmp($array[$index]['word'], $word_to_search) == 0 &&
        strcmp($array[$index]['part'],$part_of_speech) == 0)
      {
        $found = true;
      }
      else
      {
        $index++;
      }
    }
    if ($found)
    {
      unset($array[$index]);
    }
    return $index;
  }

  /**
   * This function is to make a key-value pair array
   * @param string $file_to_load is the file that load from disk
   * @return array is the paired array with key-values.
   */
  function getPaired_array(string $file_to_load): array
  {
    $paired_array = array();
    // read the file from disk
    $total_lines = file($file_to_load, FILE_IGNORE_NEW_LINES);
    //sort the file in ascending order
    asort($total_lines);
    $loop = 0;
    while ($loop < count($total_lines))
    {
      list($word, $part, $definition) = explode("\t", $total_lines[$loop]);
      $paired_array[] =
        array('word' => $word, 'part' => $part, 'definition' => $definition);
      $loop++;
    }
    unset($total_lines[$loop]);
    return $paired_array;
  }

  /**
   * This function is to delete the word
   * @param string $file_to_load is the file that load from disk
   * @param string $delete_word is the word that user want to delete
   */
  function delete_word(string $file_to_load, string $delete_word, $part_of_speech)
  {
    $paired_array = getPaired_array($file_to_load);
    // Locate the word to be deleted
    $position = search_word($paired_array, $delete_word, $part_of_speech);
    if ($position == count($paired_array))
    {
?>
      <p>
        <?= 'No entries found!';?>
      </p>
<?php
    }
    else
    {
      unset($paired_array[$position]);
    }
    output_to_file($paired_array);
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title> Manage Words </title>
    <meta name="author" content="Hengyi Li" />
    <link rel="stylesheet" href="managewords.css"/>
  </head>
  <body>
  <h1 class="header_topic"> Word Manager </h1>
  <p>
    This is the Zelda's GRE vocabulary manager, choose to add a new word or
    delete a word.
  </p>
  <hr />
  <br />
  <p class="sub-title"> Add a new word </p>
  <form method="post" action="managewords.php">
    <p>
      <label for="new_word"> What's the word? </label>
      <input type='text' id='new_word' name='new_word' required />
    </p>
    <!--
    TODO: Allowing the user to create a new part of speech to be used henceforth
    -->
    <p>
      <label for="speech"> What's the part of speech of the word? </label>
      <select name="speech" id="speech">
        <option value="noun"> noun</option>
        <option value="adjective"> adjective</option>
        <option value="adverb"> adverb</option>
        <option value="verb"> verb</option>
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
  <!--
  TODO:allowing all printable characters in the definition
  TODO: preventing any possibility of injection attack
  -->
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
      // Make sure there's no duplicate entry
      $position = search_word($paired_array, $word_new, $part_speech);
      if ($position < count($paired_array))
      {
  ?>
        <p>
          <?= 'The entry has already exists'; ?>
        </p>
  <?php
      }
      else
      {
        $paired_array[] = array('word' => $lowercase_word, 'part' =>
          $part_speech, 'definition' => $definition);
        output_to_file($paired_array);
      }
    }
  ?>
  <hr />
  <br />
  <!--
  TODO: presenting a list of each word in the file for direct deleting
  TODO: using checkboxes or a delete button attached to each word
  -->
  <p class="sub-title"> Delete a word </p>
  <form method="post" action="managewords.php">
    <?php
      $deleted_word = $_POST["del_word"];
      var_dump($part_speech);
      $part_speech = $_POST["speech_del"];
      var_dump($part_speech);
      delete_word(DEFINITION_FILENAME, $deleted_word, $part_speech);
    ?>
  </form>

  <?php
    display_entry($paired_array);
  ?>
  </body>
</html>
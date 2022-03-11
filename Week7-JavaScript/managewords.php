<?php
/**
 * @description A program to manage the word list for the GRE quiz
 * This program has two functions
 * 1. Add a word
 * 2. Delete a word from the current list
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 12.19.13.21 Beta
 */
define("DEFINITION_FILENAME", "words.txt");
define("PART_OF_SPEECH", "parts.txt");
error_reporting(E_ALL);
ini_set('display_errors', '1');

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
 * This function is to insert a new part of speech
 * @param array $part_of_speech_list is the array of the part of speech
 * @param string $new_part_speech is the speech to be inserted
 */
function insert_new_part_speech(string $new_part_speech)
{
  $part_of_speech_list = file(PART_OF_SPEECH, FILE_IGNORE_NEW_LINES);
  array_multisort($part_of_speech_list, SORT_ASC, SORT_REGULAR);
  $position = check_if_duplicate($part_of_speech_list, $new_part_speech);
  if ($position < count($part_of_speech_list))
  {
?>
    <p>
      <?= "THE PARTS YOU ADD IS ALREADY EXISTS!!!"; ?>
    </p>
  <?php
  }
  else
  {
    $part_of_speech_list[] = $new_part_speech;
    array_multisort($part_of_speech_list, SORT_ASC, SORT_REGULAR);
    file_put_contents(PART_OF_SPEECH, "");
    $index = 0;
    while ($index < count($part_of_speech_list))
    {
      $output = "$part_of_speech_list[$index]\n";
      file_put_contents(PART_OF_SPEECH, $output, LOCK_EX | FILE_APPEND);
      $index++;
    }
  }
}

/**
 * This function is to search if there's a duplicate part of speech
 * @param array $array is the part of speech array to search
 * @param string $word_to_search is the part of speech word to search in
 *   array
 * @return integer found return the index, not found return the size of the
 *   array.
 */
function check_if_duplicate(array &$array, string $word_to_search): int
{
  $found = false;
  $index = 0;
  while ($index < count($array) && !$found)
  {
    if (strcmp($array[$index], $word_to_search) == 0)
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
 * This function is to display the currently entry
 * @param string $file_to_load is the file name from  the file
 */
function display(string $file_to_load)
{
  $paired_array = getPaired_array($file_to_load);
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
    <p class="selection_to_delete_style">
      <input type="checkbox" id="<?= $index ?>" name=" choice_to_delete[]" value="<?= $index ?>" />
      <label for="<?= $index ?>"> <?= $index ?> </label>
      <?= " : ", $result, "<br />" ?>
    </p>
  <?php
  }
}

/**
 * This function is to search the index in the current array
 * @param array $array is the array to search
 * @param string $word_to_search is the  word that search for
 * @param string $part_of_speech is the speech of the word to search
 * @return integer is the index of the word position
 */
function search_word(array  &$array, string $word_to_search, string $part_of_speech): int
{
  $found = false;
  $index = 0;
  while ($index < count($array) && !$found)
  {
    if (
      strcmp($array[$index]['word'], $word_to_search) == 0
      && strcmp($array[$index]['part'], $part_of_speech) == 0
    )
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
 * This function is to deleted the word depends on the part of speech and the
 * word itself
 * @param string $file_to_load is the word file
 * @param string $delete_word is the word to delete
 * @param string $part_of_speech is the part of the speech to be deleted
 */
function delete_word(string $file_to_load, string $delete_word, string $part_of_speech)
{
  $paired_array = getPaired_array($file_to_load);
  // Locate the word to be deleted
  $position = search_word($paired_array, $delete_word, $part_of_speech);
  if ($position == count($paired_array))
  {
  ?>
    <p>
      <?= 'No entries found!'; ?>
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
    <link rel="stylesheet" href="managewords.css" />
  </head>
  <body>
    <?php
    $paired_array = getPaired_array(DEFINITION_FILENAME);
    if (isset($_POST) && isset($_POST['new_word'])
      && isset($_POST['new_part_speech'])
      && isset($_POST['def_new_word'])
    )
    {
      $word_new = htmlspecialchars(trim($_POST['new_word']));
      $part_speech = $_POST['speech'];
      $new_part_speech = htmlspecialchars(trim($_POST['new_part_speech']));
      if (!empty($new_part_speech))
      {
        $part_speech = $new_part_speech;
      }
      $definition = htmlspecialchars(trim($_POST['def_new_word']));
      $lowercase_word = strtolower($word_new);
      insert_new_part_speech($new_part_speech);
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
        $paired_array[] = array(
          'word' => $lowercase_word,
          'part' => $part_speech,
          'definition' => $definition
        );
        output_to_file($paired_array);
      }
    }
    elseif (isset($_POST) && isset($_POST['choice_to_delete']))
    {
      $deleted_list = $_POST['choice_to_delete'];
      for ($index = 0; $index < count($deleted_list); $index++)
      {
        $word_to_be_delete = $paired_array[$deleted_list[$index][0]]['word'];
        $delete_part = $paired_array[$deleted_list[$index][0]]['part'];
        delete_word(DEFINITION_FILENAME, $word_to_be_delete, $delete_part);
      }
    }
    ?>
    <h1 class="header_topic"> Word Manager </h1>
    <p>
      This is the Zelda' s GRE vocabulary manager, choose to add a new word or
      delete a word. </p>
    <hr />
    <br />
    <p class="sub-title"> Add a new word </p>
    <form method="post" action="managewords.php" id="new_words_form">
      <p>
        <label for="new_word"> What's the word? </label>
        <input type="text" id="new_word" name="new_word" />
      </p>
      <p>
        <label for="speech"> What's the part of speech of the word? </label>
        <select name="speech" id="speech">
          <option value=""> Make a choice</option>
          <?php
          $part_of_speech_list = file(PART_OF_SPEECH, FILE_IGNORE_NEW_LINES);
          array_multisort($part_of_speech_list, SORT_ASC, SORT_REGULAR);
          $index = 0;
          while ($index < count($part_of_speech_list))
          {
          ?>
            <option value="<?= $part_of_speech_list[$index] ?>">
              <?= $part_of_speech_list[$index] ?>
            </option>
          <?php
            $index++;
          }
          ?>
        </select>
      </p>
      <p>
        <label for="new_part_speech">
          Not found you want? Fill your own part of speech!
        </label>
        <input type="text" id="new_part_speech" name="new_part_speech" />
      </p>
      <p>
        <label for="def_new_word"> What's the definition of the word? </label>
        <input type='text' id="def_new_word" name="def_new_word" />
      </p>
      <p>
        <input type="submit" id="new_submit_button" value="Add word" name="submit" disabled />
      </p>
      <hr />
      <p class="sub-title"> Delete a word </p>
      <p>
        <input type='submit' value='Confirm to delete' name='delete' />
      </p>
      <?php
      display(DEFINITION_FILENAME);
      ?>
    </form>
    <script src="managewords.js"></script>
  </body>
</html>

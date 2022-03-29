<?php
/**
 * a program to accept POST data
 * in JSON format
 * @author Jon Beck
 * @version 21 March 2022
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('FILE', 'words.txt');

if (isset($_POST) && isset($_POST['payload']))
{
  $json_data = json_decode($_POST['payload']);

  $file = fopen(FILE, 'a');
  foreach ($json_data as $key => $value)
  {
    $result = htmlspecialchars($value);
    fwrite($file, "$result\t");
  }
  fwrite($file, "\n");
  fclose($file);

  $new_file = getPaired_array(FILE);
  output_to_file($new_file);

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
  file_put_contents(FILE, '');
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
    file_put_contents(FILE, $result, LOCK_EX | FILE_APPEND);
    $index++;
  }
  unset($paired_array[$index]);
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



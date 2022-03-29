<?php

/**
 * a program to supply a list of words based on a search criterion
 * in JSON format
 * @author Jon Beck
 * @version 14 March 2022
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('DEFINITION_FILENAME', 'words.txt');

/**
 * read a file of tab-separated lines into an array of arrays
 * @param $filename the name of the file to read
 * @return an array of arrays with the contents of the file
 */
function read_file_into_array($filename)
{
  $file = fopen($filename, 'r');
  $array = array();
  while (($line = fgets($file)) !== false)
  {
    $array[] = explode("\t", rtrim($line));
  }
  fclose($file);
  return $array;
}

$word_list = read_file_into_array(DEFINITION_FILENAME);

?>

<?= json_encode($word_list) ?>

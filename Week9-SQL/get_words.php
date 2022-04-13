<?php
/**
 * @brief This file is to get words from the file
 * @author Dr.Beck and Hengyi Li
 * @copyright 2022 Truman State University. All rights reserved
 * @version 1.0.0
 */

require 'dblogin.php';

$db = new PDO("mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
              $db_user, $db_pass,
              array(PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
error_reporting(E_ALL);
ini_set('display_errors', '1');
define('DEFINITION_FILENAME', 'words.txt');

/**
 * @brief This function read a file of tab-separated lines into an array of arrays
 * @param string $filename the name of the file to read
 * @return array is the array of arrays with the contents of the file
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

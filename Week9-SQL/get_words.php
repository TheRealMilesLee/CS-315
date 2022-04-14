<?php

/**
 * @brief This file is to get words from the file
 * @author Dr.Beck and Hengyi Li
 * @copyright 2022 Truman State University. All rights reserved
 * @version 1.0.3
 */

require 'dblogin.php';

/**
 * @brief This function read a file of tab-separated lines into an array of arrays
 * @param string $filename the name of the file to read
 * @return array is the array of arrays with the contents of the file
 */
function read_file_into_array($db_word)
{
	$index = 0;
	$array = array();
	while ($index < count($db_word))
	{
		$array[] =
			array('word' => $db_word[$index]["word"], 'part' => $db_word[$index]["part"], 'definition' => $db_word[$index]["definition"]);
		$index++;
	}
	return $array;
}

if (isset($_GET) && isset($_GET['search']) && preg_match('/^[a-z]+$/', $_GET['search']))
{
	$search = $_GET['search'];
	$db = new PDO(
		"mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
		$db_user,
		$db_pass,
		array( PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE =>
		PDO::ERRMODE_EXCEPTION)
	);
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	define('DEFINITION_FILENAME', 'words.txt');

	$word = $db->prepare('select word.word, part.part, word.definition from word join part on word.part_id = part.id where word like "$search%"' );
	$word->execute();
	$db_word = $word->fetchAll();
	$word_list = read_file_into_array($db_word);
	var_dump($word_list[0]);
}
?>
<?= json_encode($word_list) ?>

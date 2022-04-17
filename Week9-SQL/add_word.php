<?php

/**
 * a program to accept POST data
 * in JSON format
 * @author Jon Beck
 * @version 21 March 2022
 */

require 'dblogin.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$duplicate = true;
if (isset($_POST) && isset($_POST['duplicate']))
{
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
  );
  $duplicate_array = json_decode($_POST['duplicate']);
  $words_duplicate = $duplicate_array[0];
  $speech_duplicate = $duplicate_array[1];
  $search = $db->prepare("select word.word, part.part from word
                        join part on word.part_id = part_id
                        where word.word = '$words_duplicate' and part.part ='$speech_duplicate';");
  $search->execute();
  $search_results = $search->fetchAll();
  if (empty($search_results))
  {
    $duplicate = false;
  ?>
    <?= json_encode($duplicate) ?>
  <?php
  }
  else
  {
  ?>
    <?= json_encode($duplicate) ?>
  <?php
  }
}

if (isset($_POST) && isset($_POST['new_entry']))
{
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
  );
  $json_data = json_decode($_POST['new_entry']);
  $json_data[2] = str_replace("π", "&", $json_data[2]);
  $json_data[2] = str_replace("√", "+", $json_data[2]);
  $new_word_entry = $json_data[0];
  $new_speech_entry = $json_data[1];
  if ($new_speech_entry == "adjective")
  {
    $insert_speech = 1;
  }
  else if ($new_speech_entry == "adverb")
  {
    $insert_speech = 2;
  }
  else if($new_speech_entry == "noun")
  {
    $insert_speech = 3;
  }
  else
  {
    $insert_speech = 4;
  }
  $new_definition_entry = htmlspecialchars($json_data[2]);
  $insert_query = $db->prepare("insert into word (word, part_id, definition) values ('$new_word_entry','$insert_speech','$new_definition_entry');");
  $insert_query->execute();
}

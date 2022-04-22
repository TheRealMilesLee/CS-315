<?php

/**
 * a program to accept POST data
 * in JSON format
 * @author Jon Beck and Hengyi Li
 * @version 21 March 2022
 */

require 'dblogin.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$db = new PDO(
  "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
  $db_user,
  $db_pass,
  array(
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  )
);

function logger($s)
{
  $file = fopen("logger.txt", 'a');
  fwrite($file, $s . PHP_EOL);
  fclose($file);
}

if (isset($_POST) && isset($_POST['validate']))
{
  $json_data = json_decode($_POST['validate']);
  $words_entry = htmlspecialchars($json_data[0]);
  $speech_entry = $json_data[1];
  $json_data[2] =  str_replace("π", "&", $json_data[2]);
  $json_data[2] = str_replace("√", "+", $json_data[2]);
  $definition_entry = $json_data[2];
  $search = $db->prepare("select word.word, part.part from word
                        join part on word.part_id = part.id
                        where word.word = :duplicate_word and part.part = :duplicate_part;");
  $search->bindValue(':duplicate_word', $words_entry, PDO::PARAM_STR);
  $search->bindValue(':duplicate_part', $speech_entry, PDO::PARAM_STR);
  $search->execute();
  $search_results = $search->fetchAll();
  if (empty($search_results))
  {
    $duplicate = "False";
    if ($speech_entry == "adjective")
    {
      $insert_speech = 1;
    }
    else if ($speech_entry == "adverb")
    {
      $insert_speech = 2;
    }
    else if ($speech_entry == "noun")
    {
      $insert_speech = 3;
    }
    else
    {
      $insert_speech = 4;
    }
    $new_definition_entry = htmlspecialchars($json_data[2]);
    $insert_query = $db->prepare('insert into word (word, part_id, definition)
  values (:word, :part_id, :definition);');
    $insert_query->bindValue(':word', $words_entry, PDO::PARAM_STR);
    $insert_query->bindValue(':part_id', $insert_speech, PDO::PARAM_INT);
    $insert_query->bindValue(':definition', $definition_entry, PDO::PARAM_STR);
    $insert_query->execute();
  }
  else
  {
    $duplicate = "True";
    logger("NOT empty");
  }
}
?>
<?= json_encode($duplicate) ?>

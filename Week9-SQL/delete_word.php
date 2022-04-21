<?php
require 'dblogin.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST) && isset($_POST['delete_word']))
{
  $delete_entry = json_decode($_POST['delete_word']);
  $clean_word = htmlspecialchars($delete_entry[0]);
  $clean_part = htmlspecialchars($delete_entry[1]);
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE =>
    PDO::ERRMODE_EXCEPTION)
  );
  if ($clean_part == "adjective")
  {
    $delete_speech = 1;
  }
  else if ($clean_part == "adverb")
  {
    $delete_speech = 2;
  }
  else if ($clean_part == "noun")
  {
    $delete_speech = 3;
  }
  else
  {
    $delete_speech = 4;
  }

  for ($index = 0; $index < count($delete_entry); $index++)
  {
    $delete_action = $db->prepare('delete from word where word.word = :del_word and word.part_id = :del_part;');
    $delete_action->bindValue(':del_word', $clean_word, PDO::PARAM_STR);
    $delete_action->bindValue(':del_part', $delete_speech, PDO::PARAM_INT);
    $delete_action->execute();
  }
}
?>

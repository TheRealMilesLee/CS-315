<?php
require 'dblogin.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST) && isset($_POST['delete_word']))
{
  $delete_words = json_decode($_POST['delete_word']);
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE =>
    PDO::ERRMODE_EXCEPTION)
  );
  for ($index = 0; $index < count($delete_words); $index++)
  {
    $word = $db->prepare("delete from word where word = '$delete_words[$index]';");
    $word->execute();
  }
}
?>

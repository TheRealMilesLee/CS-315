<?php
require 'dblogin.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
function logger($s)
{
  $file = fopen("logger.txt", 'a');
  fwrite($file, $s . PHP_EOL);
  fclose($file);
}
// if (isset($_POST) && isset($_POST['delete_word']))
// {
  $array_to_be_deleted = $_POST['delete_word'];
  logger("Test");
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE =>
    PDO::ERRMODE_EXCEPTION)
  );
  for ($index = 0; $index < $array_to_be_deleted; $index++)
  {
    $word = $db->prepare("delete from word where word = '$array_to_be_deleted[$index]';");
    $word->execute();
  }
// }
?>

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
if (isset($_POST) && isset($_POST['delete_word']))
{
  $delete_array = $_POST['delete_word'];
  $delete_words = json_decode($delete_array);
  if ($delete_array === null)
  {
    logger("Nothing here");
  }
  else
  {
    logger($delete_array);
  }
  $db = new PDO(
    "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
    $db_user,
    $db_pass,
    array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE =>
    PDO::ERRMODE_EXCEPTION)
  );
  for ($index = 0; $index < $delete_words; $index++)
  {
    $word = $db->prepare("delete from word where word = '$delete_words[$index]';");
    $word->execute();
  }
}
?>

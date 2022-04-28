<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require 'dblogin.php';
$db = new PDO(
  "mysql:host=$db_host;dbname=hl3265;charset=utf8mb4",
  $db_user,
  $db_pass,
  array(
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  )
);
$already_logged_in = false;

function logger($s)
{
  $file = fopen('logger.txt', 'a');
  fwrite($file, $s . PHP_EOL);
  fclose($file);
}

function read_database_into_array($db_word)
{
  $index = 0;
  $array = array();
  while ($index < count($db_word))
  {
    $array[] =
      array(
        'username' => $db_word[$index]["username"],
        'screen_name' => $db_word[$index]["screen_name"],
        'user_password' => $db_word[$index]["user_password"],
        'is_administrator' => $db_word[$index]["is_administrator"]
      );
    $index++;
  }
  return $array;
}

if (!(isset($_SESSION['username_login'])))
{
  if (isset($_POST) && isset($_POST['username_login']) && isset($_POST['password_login']))
  {
    $username = htmlspecialchars($_POST['username_login']);
    $password = $_POST['password_login'];
    $search = $db->prepare("select username.username, username.screen_name,
        user_password.user_password, username.is_administrator from username
        join user_password on username.password_id = user_password.id
        where username.username = :username;");
    $search->bindValue(':username', $username, PDO::PARAM_STR);
    $search->execute();
    $search_results = $search->fetchAll(PDO::FETCH_ASSOC);
    $user = read_database_into_array($search_results);
    $is_admin = $user[0]['is_administrator'];
    if (password_verify($password, $user[0]['user_password']) == true)
    {
      $_SESSION['username_login'] = $user[0]['username'];
      $_SESSION['screen_name'] = $user[0]['screen_name'];
      $_SESSION['is_administrator'] = $user[0]['is_administrator'];
      logger($_SESSION['is_administrator']);
      if ($is_admin == 1)
      {
        header('Location: managewords.php');
      }
      else
      {
        header('Location: quiz.php');
      }
      exit();
    }
    else
    {
      $error_msg = 'Username-password pair is invalid';
    }
  }
}
else
{
  $already_logged_in = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> Bulletin Board : Login</title>
  <meta name="author" content="Hengyi Li" />
  <link rel="icon" href="datacenter.png">
  <link rel="stylesheet" href="managewords_portal.css" />
</head>

<body>
  <div class="prompt">
    <h1>Login</h1>
    <?php
    if ($already_logged_in)
    {
    ?>
      <p> You have already logged in!</p>
      <?php
      if ($_SESSION['is_administrator'] == 1)
      {
      ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="utf-8" />
          <title> Database Management System </title>
          <meta name="author" content="Hengyi Li" />
          <link rel="icon" href="datacenter.png">
          <link rel="stylesheet" href="managewords_portal.css" />
        </head>

        <body>
          <button type="submit" class="submit" id="admin_page"> Take me to the main page </button>
          <script src="admin_jump.js"></script>
        </body>

        </html>
      <?php
      }
      else
      {
      ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="utf-8" />
          <title> Database Management System </title>
          <meta name="author" content="Hengyi Li" />
          <link rel="icon" href="datacenter.png">
          <link rel="stylesheet" href="managewords_portal.css" />
        </head>

        <body>
          <button type="submit" class="submit" id="user_page"> Take me to the main page</button>
          <script src="admin_jump.js"></script>
        </body>

        </html>
      <?php
      }
    }
    else
    {
      ?>
      <p> By type in the username and the password, you will be redirected to the home page</p>
  </div>
  <div id="login">
    <form method="post" action="managewords_portal_login.php">
      <fieldset class="username">
        <label class="login_input_label" for="username_login">Please input your username </label>
        <br />
        <input class="login_input" type="text" id="username_login" name="username_login" placeholder="Username" required />
        <b id="notification_username"> &bull; </b>
      </fieldset>
      <br />
      <fieldset class="password">
        <label class="login_input_label" for="password_login">Please input your Password </label>
        <input class="login_input" type="password" id="password_login" name="password_login" placeholder="Password" required />
        <b id="notification_password"> &bull; </b>
      </fieldset>
      <br />
      <button type="submit" class="submit" id="login_button"> Log In </button>
    </form>
    <div>
      <p> Don't have a account? Sign up here! </p>
      <button type="submit" class="submit" id="signup_button"> Sign Up </button>
      <br />
    </div>
  </div>
<?php
    }
?>
<script src="managewords_portal.js"></script>
</body>

</html>

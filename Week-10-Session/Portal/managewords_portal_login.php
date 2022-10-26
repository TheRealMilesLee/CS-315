<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require '../Database/dblogin.php';
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
        'password_id' => $db_word[$index]["password_id"],
        'is_administrator' => $db_word[$index]["is_administrator"]
      );
    $index++;
  }
  return $array;
}

if (!(isset($_SESSION['username'])))
{
  if (isset($_POST) && isset($_POST['username_login']) && isset($_POST['password_login']))
  {
    $username = $_POST['username_login'];
    $password = $_POST['password_login'];
    $search = $db->prepare("select username.username, username.screen_name,
        user_password.user_password, username.password_id, username.is_administrator
        from username join user_password on username.password_id = user_password.id
        where username.username = :username;");
    $search->bindValue(':username', $username, PDO::PARAM_STR);
    $search->execute();
    $search_results = $search->fetchAll(PDO::FETCH_ASSOC);
    $user = read_database_into_array($search_results);
    if (password_verify($password, $user[0]['user_password']) == true)
    {
      $_SESSION['username'] = $user[0]['username'];
      $_SESSION['screen_name'] = $user[0]['screen_name'];
      $_SESSION['password_id'] = $user[0]['password_id'];
      $_SESSION['is_administrator'] = $user[0]['is_administrator'];
      if ($_SESSION['is_administrator'] == 1)
      {
        header('Location: ../Admin/managewords.php');
      }
      else
      {
        header('Location: ../User/Vocabulary.php');
      }
      exit();
    }
    else
    {
      header("Location: WrongInput.php");
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
  <link rel="icon" href="../Resources/favicon.png">
  <link rel="stylesheet" href="managewords_portal.css" />
</head>

<body>
  <div class="prompt">
    <h1> Login </h1>
    <?php
    if ($already_logged_in)
    {
    ?>
      <p> You have already logged in! </p>
      <?php
        header("Location: Already_logged.php");
    }
    else
    {
      ?>
      <p> By type in the username and the password, you will be redirected to the home page </p>
  </div>
  <div id="login" class="prompt">
    <form method="post" action="managewords_portal_login.php">
      <!-- User name input -->
      <fieldset class="username">
        <label class="login_input_label" for="username_login">
          Please input your username
        </label>
        <br />
        <input class="login_input" type="text" id="username_login" name="username_login" placeholder="Username" required />
        <b id="notification_username"> &bull; </b>
      </fieldset>
      <br />
      <!-- Password input -->
      <fieldset class="password">
        <label class="login_input_label" for="password_login">
          Please input your Password
        </label>
        <input class="login_input" type="password" id="password_login"
        name="password_login" placeholder="Password" required />
        <b id="notification_password"> &bull; </b>
      </fieldset>
      <br />
      <button type="submit" class="submit" id="login_button"> Log In </button>
    </form>
    <!-- Redirected to sign up -->
    <div class="prompt">
      <p> Don't have a account? Sign up here! </p>
      <button type="submit" class="submit" id="signup_button"> Sign Up </button>
      <br />
    </div>
    <div class="prompt">
      <h2> Password requirement </h2>
      <p>
        Username only allow letters, digits, and underscores. <br />
        Password cannot contain spaces, must be at least 6 characters long,
        must contain at least one each of uppercase, lowercase, digit, and punctuation characters.
      </p>
    </div>
  </div>
<?php
    }
?>
<script src="managewords_portal.js"></script>
</body>
</html>

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
        'user_password_id' => $db_word[$index]["password_id"],
        'is_administrator' => $db_word[$index]["is_administrator"]
      );
    $index++;
  }
  return $array;
}

if (!(isset($_SESSION['is_administrator'])))
{
  if (
    isset($_POST) && isset($_POST['username_signup'])
    && isset($_POST['nickname_signup'])
    && isset($_POST['password_signup'])
  )
  {
    $username = $_POST['username_signup'];
    $nickname = htmlspecialchars($_POST['nickname_signup']);
    $password = $_POST['password_signup'];
    $search = $db->prepare("select username.username, username.screen_name,
            user_password.user_password, username.password_id, username.is_administrator
            from username join user_password
            on username.password_id = user_password.id
            where username.username = :username;");
    $search->bindValue(':username', $username, PDO::PARAM_STR);
    $search->execute();
    $search_results = $search->fetchAll(PDO::FETCH_ASSOC);
    $user = read_database_into_array($search_results);
    if (count($user) > 0)
    {
?>
      <script src="duplicate_alert.js"></script>
  <?php
    }
    else
    {
      $password_new_insert = 'insert into user_password(user_password)
      values(:user_password);';
      $password_new = $db->prepare($password_new_insert);
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $password_new->bindValue(':user_password', $hashed_password);
      $password_new->execute();
      $find_new_insert_id = 'select user_password.id from user_password where user_password.user_password = :history;';
      $get_id = $db->prepare($find_new_insert_id);
      $get_id->bindValue(':history', $hashed_password);
      $get_id->execute();
      $result = $get_id->fetchAll(PDO::FETCH_ASSOC);
      $id = $result[0]['id'];
      $sql = 'insert into username(username, screen_name, password_id, is_administrator) values (:username_new, :screen_name_new, :password_id_new, False);';
      $statement = $db->prepare($sql);
      $statement->bindValue(':username_new', $username);
      $statement->bindValue(':screen_name_new', $nickname);
      $statement->bindValue(':password_id_new', $id);
      $statement->execute();
      $_SESSION['username_login'] = $username;
      $_SESSION['screen_name'] = $nickname;
      $_SESSION['password_id'] = $id;
      $_SESSION['is_administrator'] = 0;
      header('Location: quiz.php');
    }
  }
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
    <div class="prompt">
      <h1>Sign Up</h1>
      <p> Create a new account now by type in the username, screen name and the password </p>
    </div>
    <div id="signup">
      <form method="post" action="managewords_portal_signup.php">
        <fieldset class="username">
          <label class="login_input_label" for=" username"> Create a username </label>
          <input class="login_input" type="text" id="username_signup" name="username_signup" placeholder="Username" required />
        </fieldset>
        <br />
        <fieldset class="nickname">
          <label class="login_input_label" for="nickname"> Create a nickname </label>
          <input class="login_input" type="text" id="nickname_signup" name="nickname_signup" placeholder="nickname" required />
        </fieldset>
        <br />
        <fieldset class="password">
          <label class="login_input_label" for=" password"> Create your Password </label>
          <input class="login_input" type="password" id="password_signup" name="password_signup" placeholder="Password" required />
        </fieldset>
        <br />
        <fieldset class="password">
          <label class="login_input_label" for=" password"> Retype your Password </label>
          <input class="login_input" type="password" id="password_signup_re" name="password_signup_re" placeholder="Password" required />
        </fieldset>
        <br />
        <button type="submit" class="submit" name="submit"> Sign Up Now ! </button>
      </form>
      <br />
      <p> Have an account already? Click below to login</p>
      <a href="managewords_portal_login.php">
        <button type="submit" class="submit"  id="login_button" name="submit"> Log In </button>
      </a>
    </div>
  <?php
}
else
{
  ?>
    <p> Nice try, but you have already Logged in</p>
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
        <button type="submit" class="submit" id="admin_page"> Take me to main page </button>
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
        <button type="submit" class="submit" id="user_page"> Take me to Users page </button>
        <script src="admin_jump.js"></script>
      </body>

      </html>
  <?php
    }
  }
  ?>
  <script src="managewords_portal.js"></script>
  </body>

  </html>

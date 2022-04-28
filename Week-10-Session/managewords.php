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

if (isset($_SESSION['is_administrator']))
{
  $logged_in = $_SESSION['is_administrator'];
  if ($logged_in === 1)
  {
    if (isset($_POST) && isset($_POST['username_login']) && isset($_POST['password_login']))
    {
      $username = htmlspecialchars($_POST['username_login']);
      $password = $_POST['password_login'];
      $search = $db->prepare("select username.username, username.screen_name,
            user_password.user_password, username.password_id, username.is_administrator
            from username join user_password
            on username.password_id = user_password.id
            where username.username = :username;");
      $search->bindValue(':username', $username, PDO::PARAM_STR);
      $search->execute();
      $search_results = $search->fetchAll(PDO::FETCH_ASSOC);
      $user = read_database_into_array($search_results);
      $_SESSION['username_login'] = $user[0]['username'];
      $_SESSION['screen_name'] = $user[0]['screen_name'];
      $_SESSION['password_id'] = $user[0]['user_password_id'];
      $_SESSION['is_administrator'] = $user[0]['is_administrator'];
      $is_admin = $user[0]['is_administrator'];
      if (password_verify($password, $user[0]['user_password']) == true)
      {
        if (isset($_POST['nickname_new']) && isset($_POST['password_new']))
        {
          $new_nickname = $_POST['nickname_new'];
          $new_password = $_POST['password_new'];
          if (empty($new_password))
          {
            $sql = 'update username set screen_name = :screen_name where username = :username;';
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', $_SESSION['username_login']);
            $statement->bindValue(':screen_name', $new_nickname);
            $statement->execute();
            $_SESSION['screen_name'] = $new_nickname;
          }
          else if (empty($new_nickname))
          {
            $password_change = 'update user_password set user_password = :user_password where id = :user_id;';
            $password_modification = $db->prepare($password_change);
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_modification->bindValue(':user_id', $_SESSION['password_id']);
            $password_modification->bindValue(':user_password', $hashed_password);
            $password_modification->execute();
          }
          else
          {
            $sql = 'update username set screen_name = :screen_name where username = :username;';
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', $_SESSION['username_login']);
            $statement->bindValue(':screen_name', $new_nickname);
            $statement->execute();
            $password_change = 'update user_password set user_password = :user_password where id = :user_id;';
            $password_modification = $db->prepare($password_change);
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_modification->bindValue(':user_id', $_SESSION['password_id']);
            $password_modification->bindValue(':user_password', $hashed_password);
            $password_modification->execute();
            $_SESSION['screen_name'] = $new_nickname;
          }
        }
      }
    }
    if (isset($_POST['username_account']))
    {
      if (isset($_POST['admin_choice']))
      {
        $administrator = $_POST['admin_choice'];
        $username_change_status = $_POST['username_account'];
        if ($username_change_status === $_SESSION['username_login'])
        {
?>
          <script src="not_same_user.js"></script>
          <?php
        }
        else
        {
          $status_update = 'update username set is_administrator = :is_admin where username = :username;';
          $update_choice = $db->prepare($status_update);
          $update_choice->bindValue(':is_admin', $administrator);
          $update_choice->bindValue(':username', $username_change_status);
          $update_choice->execute();
        }
      }
      if (isset($_POST['delete_choice']))
      {
        if ($_POST['delete_choice'] == 1)
        {
          if ($username_change_status === $_SESSION['username_login'])
          {
          ?>
            <script src="not_same_user.js"></script>
    <?php
          }
          else
          {
            $user_to_delete = $username_change_status;
            $prepare_db = 'select username.username, username.password_id from username where username.username = :username; ';
            $db_search = $db->prepare($prepare_db);
            $db_search->bindValue(':username', $user_to_delete);
            $db_search->execute();
            $search_result_delete = $db_search->fetchAll(PDO::FETCH_ASSOC);
            $password_id = $search_result_delete[0]['password_id'];
            $delete_name = $db->prepare('delete from username where username.username = :name;');
            $delete_name->bindValue(':name', $user_to_delete);
            $delete_name->execute();
            $delete_password = $db->prepare('delete from user_password where user_password.id = :id');
            $delete_password->bindValue(':id', $password_id);
            $delete_password->execute();
          }
        }
      }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8" />
      <title> Manage Words </title>
      <meta name="author" content="Hengyi Li" />
      <link rel="icon" href="Diary.png">
      <link rel="stylesheet" href="managewords.css" />
    </head>

    <body>
      <div class="manage_word">
        <div id="intro_header">
          <h1 class="word_manager"> Word Manager </h1>
          <p class="prompt">
            Welcome, <?= $_SESSION['screen_name'] ?>. You login as Administrator. <br />
            Here is the control panel, enjoy.
          </p>
        </div>
        <div id="add_word">
          <!-- Add word section -->
          <p class="subtitle"> Add a new word </p>
          <!-- Add the new word -->
          <div id="add_new_word">
            <p>
              <label for="new_word"> What's the word? </label>
              <input type="text" id="new_word" name="new_word" />
              <b id="word_prompt" class="prompt_user, warning_sign">&excl;</b>
            </p>
          </div>
          <!-- Add the part of speech -->
          <div>
            <p>
              <label for="speech"> Part of speech is </label>
              <select name="speech" id="speech">
                <option value=""> Make a choice </option>
                <option value="noun"> noun </option>
                <option value="adjective"> adjective </option>
                <option value="adverb"> adverb </option>
                <option value="verb"> verb </option>
              </select>
              <b id="speech_prompt" class="prompt_user, warning_sign">&excl;</b>
            </p>
          </div>
          <!-- Add the definition -->
          <div>
            <p>
              <label for="def_new_word"> Word Definition Is </label>
              <input type='text' id="def_new_word" name="def_new_word" />
              <b id="definition_prompt" class="prompt_user, warning_sign">
                &excl; </b>
            </p>
          </div>
          <!-- Add word submit button -->
          <div>
            <p>
              <input type="submit" class="submit" id="add_button" value="Add word" name="submit" disabled />
            </p>
          </div>
        </div>
        <!-- Delete word section -->
        <div id="delete_word">
          <p class="subtitle"> Delete a word </p>
          <p> Type in the box below to search the word that you want to delete
          </p>
          <!-- Delete word button -->
          <div class="search_delete_box">
            <input type="text" id="search_delete" name="search_delete" />
            <input type="submit" class="submit" id="delete_submit" value="Delete!" name="submit" disabled />
          </div>
        </div>
      </div>
      <div>
        <h2 class="word_manager"> User Manager </h2>
        <p class="prompt">
          Fill the form below to change user status <br />
          Go down below to log out or go to the quiz page <br />
          If you want to change the user privilege, look down for information.
        </p>
        <form class="name_and_password" method="post" action="managewords.php">
          <fieldset class="username_login">
            <label class="input_label" for="username_login">Please input your username </label>
            <input class="input" type="text" id="username_login" name="username_login" placeholder="Username" required />
            <b id="notification_username"> &bull; </b>
          </fieldset>
          <fieldset class="password">
            <label class="input_label" for="password_login"> Please input your Password </label>
            <input class="input" type="password" id="password_login" name="password_login" placeholder="Password" required />
            <b id="notification_password"> &bull; </b>
          </fieldset>
          <fieldset class="nickname">
            <label class="input_label" for="nickname">
              Please input your new nickname
            </label>
            <input class="input" type="text" id="nickname_new" name="nickname_new" placeholder="New nickname" />
          </fieldset>
          <fieldset class="password">
            <label class="input_label" for="password_new">
              Please input your new Password
            </label>
            <input class="input" type="password" id="password_new" name="password_new" placeholder="New password" />
          </fieldset>
          <button type="submit" class="submit" id="name_pass_manage" name="submit">
            Submit
          </button>
        </form>
        <p class="prompt"> Here is the account management </p>
        <form class="privilege" method="post" action="managewords.php">
          <fieldset class="username_login">
            <label class="input_label" for="username_account">Please input the username </label>
            <input class="input" type="text" id="username_account" name="username_account" placeholder="Username" required />
            <b id="notification_username"> &bull; </b>
          </fieldset>
          <fieldset class="is_admin">
            <label class="input_label" for="admin_choice">
              Do you want to change the admin status? (1 for yes, 0 for no)
            </label>
            <input class="input" type="number" id="admin_choice" name="admin_choice" max=1 min=0 placeholder="Administrator status" />
          </fieldset>
          <fieldset class="is_admin">
            <label class="input_label" for="delete_choice">
              Do you want to delete the user? (1 for yes, 0 for no)
            </label>
            <input class="input" type="number" id="delete_choice" name="delete_choice" max=1 min=0 placeholder="Delete status" />
          </fieldset>
          <button type="submit" class="submit" id="account_manage" name="submit"> Submit </button>
        </form>
        <div class="quiz_button">
          <p class="prompt">
            If you finished your modification, click down below to go back to the quiz
          </p>
          <button type="submit" class="submit" id="user_page"> Quiz </button>
        </div>
        <div class="logout_button">
          <p class="prompt"> Click to log out</p>
          <a href="logout.php">
            <button type="submit" class="submit" name="logout"> Log Out </button>
          </a>
        </div>
      </div>
      <script src="managewords.js"></script>
    <?php
  }
  else
  {
    ?>
      <p> Nice try, but you are not the Administrator!</p>
    <?php
  }
}
else
{
    ?>
    <p> Nice try, but you shall no pass! </p>
  <?php
}
  ?>
    </body>

    </html>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> Bulletin Board : Login</title>
  <meta name="author" content="Hengyi Li" />
  <link rel="icon" href="datacenter.png">
  <link rel="stylesheet" href="BulletinBoard.css" />
</head>

<body>
  <div class="prompt">
    <h1>Login</h1>
    <p> By type in the username and the password, you will be redirected to the home page</p>
  </div>
  <div id="login">
    <fieldset class="username">
      <label class="login_input_label" for="username_login">Please input your username </label>
      <br />
      <input class="login_input" type="text" id="username_login" name="username_login" placeholder="Username" required />
      <b id="notification_username"> &bull; </b>
    </fieldset>
    <br />
    <fieldset class="password">
      <label class="login_input_label" for="password_login">Please input your Password </label>
      <input class="login_input" type="password" id="password_login" name="password_login" placeholder="Password"  required />
      <b id="notification_password"> &bull; </b>
    </fieldset>
    <br />
    <button type="submit" class="submit" name="submit"> Log In </button>
    <p> Don't have a account? Sign up here! </p>
    <a href="BulletinBoardSignUp.php">
      <button type="submit" class="submit" name="submit"> Sign Up </button>
    </a>
    <br />
  </div>
  <script src="BulletinBoard.js"></script>
</body>
</html>

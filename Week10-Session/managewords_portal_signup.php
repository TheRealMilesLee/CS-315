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
    <p> Create a new account  now by type in the username, screen name and the password </p>
  </div>
  <div id="signup">
    <fieldset class="username">
      <label class="login_input_label" for=" username"> Create a username </label>
      <input class="login_input" type="text" id="username" name="username" placeholder="Username" required />
    </fieldset>
    <br />
    <fieldset class="nickname">
      <label class="login_input_label" for="nickname"> Create a nickname </label>
      <input class="login_input" type="text" id="nickname" name="nickname" placeholder="nickname" required />
    </fieldset>
    <br />
    <fieldset class="password">
      <label class="login_input_label" for=" password"> Create your Password </label>
      <input class="login_input" type="password" id="password" name="password" placeholder="Password" required />
    </fieldset>
    <br />
    <button type="submit" class="submit" name="submit"> Sign Up Now ! </button>
    <br />
    <p> Have an account already? Click below to login</p>
    <a href="managewords_portal_login.php">
    <button type="submit" class="submit" name="submit"> Log In </button>
    </a>
  </div>
  <script src="managewords_portal.js"></script>
</body>
</html>


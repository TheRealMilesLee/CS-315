<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> Database Management System </title>
  <meta name="author" content="Hengyi Li" />
  <link rel="icon" href="datacenter.png">
  <link rel="stylesheet" href="database_management_system.css" />
</head>

<body>
  <div class="prompt">
    <h1>Login</h1>
    <p> By type in the user name and the password, you will be redirected to the home page</p>
  </div>
  <div class="login">
    <fieldset id="username_login">
      <label class="login_input_label" for=" username">Please input your username </label>
      <input class="login_input" type="text" id="username" name="username" placeholder="Username" required />
    </fieldset>
    <br />
    <fieldset id="password_login">
      <label class="login_input_label" for=" password">Please input your Password </label>
      <input class="login_input" type="text" id="password" name="password" placeholder="Password" required />
    </fieldset>
    <br />
    <button type="submit" id="login_submit" name="login_submit"> Log In </button>
    <br />
  </div>
</body>

</html>

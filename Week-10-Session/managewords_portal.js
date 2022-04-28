"use strict";
// a global variable to prevent race
let xhr = null;
// Get the element by using the id

function get_by_id(id)
{
  return document.getElementById(id);
}
// Get the element by using the name
function get_by_name(name)
{
  return document.getElementsByName(name);
}

window.onload = function ()
{
  if (get_by_id("signup_button") !== null)
  {
    get_by_id("signup_button").onclick = function ()
    {
      jump_signup();
    };
  }
  else if (get_by_id("login_button") !== null)
  {
    get_by_id("login_button").onclick = function ()
    {
      jump_login();
    };
  }
  else
  {
    get_by_id("signup_button").onclick = function ()
    {
      jump_signup();
    };
    get_by_id("login_button").onclick = function ()
    {
      jump_login();
    };
  }

  if (get_by_id("password_signup_re") !== null)
  {
    get_by_id("password_signup_re").onchange = function ()
    {
      let origin_set_password = get_by_id("password_signup").value;
      let re_set_password = get_by_id("password_signup_re").value;
      if (origin_set_password === re_set_password)
      {

      }
      else
      {
        window.alert("They does not match!");
        re_set_password.value = "";
      }
    };
  }

  if (get_by_id("login") !== null)
  {
    get_by_id("login").onchange = function ()
    {
      username_validation();
      password_validation();
    }
  }
};

function username_validation()
{
  let regex_word = new RegExp("\\w+");
  console.log(get_by_id("username_login").value);
  if (get_by_id("username_login").value === "")
  {
    get_by_id("notification_username").classList.remove("warning_sign_style");
    get_by_id("notification_username").classList.remove("warning_prompt_style");
    get_by_id("notification_username").classList.remove("pass_sign_style");
    get_by_id("notification_username").innerHTML = '&bull;';
  }
  else  if (!regex_word.test(get_by_id("username_login").value))
  {
    get_by_id("notification_username").innerHTML = '&times;';
    get_by_id("notification_username").classList.remove("pass_sign_style");
    get_by_id("notification_username").classList.add("warning_prompt_style");
    clean_input();
  }
  else
  {
    get_by_id("notification_username").classList.remove("warning_sign_style");
    get_by_id("notification_username").classList.remove("warning_prompt_style");
    get_by_id("notification_username").classList.add("pass_sign_style");
    get_by_id("notification_username").innerHTML = "&check;";
  }
}

function password_validation()
{
  let password_validation_regex = new RegExp("^[[^\s]{6,}\w!@#$%^&*()_+-=,.:\"\;\'] ");
  console.log(get_by_id("password_login").value);
  if (get_by_id("password_login").value === "")
  {
    get_by_id("notification_password").classList.remove("warning_sign_style");
    get_by_id("notification_password").classList.remove("warning_prompt_style");
    get_by_id("notification_password").classList.remove("pass_sign_style");
    get_by_id("notification_password").innerHTML = '&bull;';
  }
  else if (!password_validation_regex.test(get_by_id("password_login").value))
  {
    get_by_id("notification_password").innerHTML = '&times;';
    get_by_id("notification_password").classList.remove("pass_sign_style");
    get_by_id("notification_password").classList.add("warning_prompt_style");
  }
  else
  {
    get_by_id("notification_password").classList.remove("warning_sign_style");
    get_by_id("notification_password").classList.remove("warning_prompt_style");
    get_by_id("notification_password").classList.add("pass_sign_style");
    get_by_id("notification_password").innerHTML = "&check;";
  }
}

function clean_input()
{
  get_by_id("username_login").value = "";
  get_by_id("password_login").value = "";
}



function jump_signup()
{
  window.location.href = "managewords_portal_signup.php";
}

function jump_login()
{
  window.location.href = "managewords_portal_login.php";
}




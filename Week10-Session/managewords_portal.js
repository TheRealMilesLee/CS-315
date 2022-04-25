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

get_by_id("login").onchange = function ()
{
  username_validation();
  password_validation();
}

function username_validation()
{
  let regex_word = new RegExp("^[\w]+$");
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

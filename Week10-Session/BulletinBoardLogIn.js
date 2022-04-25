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

function get_by_tag(tag)
{
  return document.getElementsByTagName
}

get_by_id("login").onchange = function ()
{
  username_validation();

}

function username_validation()
{
  let regex_word = new RegExp("^[A-Za-z0-9_]+$");
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

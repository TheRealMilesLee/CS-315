"use strict";
function get_by_id(id)
{
  return document.getElementById(id);
}
get_by_id("signup_page").onclick = jump_signup;

function jump_signup()
{
  window.location.href = "../Portal/managewords_portal_signup.php";
}

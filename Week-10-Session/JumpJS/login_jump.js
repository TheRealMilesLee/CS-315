"use strict";
function get_by_id(id)
{
  return document.getElementById(id);
}
get_by_id("login_page").onclick = jump_login;

function jump_login()
{
  window.location.href = "../Portal/managewords_portal_login.php";
}

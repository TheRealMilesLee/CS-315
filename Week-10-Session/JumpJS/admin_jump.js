"use strict";
function get_by_id(id)
{
  return document.getElementById(id);
}

get_by_id("admin_page").onclick = jump_admin;
function jump_admin()
{
  window.location.href = "../Admin/managewords.php";
}

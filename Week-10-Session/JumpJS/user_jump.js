"use strict";
function get_by_id(id)
{
  return document.getElementById(id);
}
get_by_id("user_page").onclick = jump_user;

function jump_user()
{
  window.location.href = "../User/Vocabulary.php";
}

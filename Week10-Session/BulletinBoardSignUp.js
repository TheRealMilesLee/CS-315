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
  return document.getElementsByTagName;
}



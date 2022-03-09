"use strict";

function $(id)
{
  return document.getElementById(id);
}

window.onload = function ()
{
  $("add-cb").onclick = click_add;
  $("del-cb").onclick = click_del;
};

function click_add()
{
  $("del-cb").checked = false;
  $("add-wrapper").classList.remove("invisible");
  $("add-wrapper").classList.add("visible");
  $("del-wrapper").classList.remove("visible");
  $("del-wrapper").classList.add("invisible");
}

function click_del()
{
  $("add-cb").checked = false;
  $("del-wrapper").classList.remove("invisible");
  $("del-wrapper").classList.add("visible");
  $("add-wrapper").classList.remove("visible");
  $("add-wrapper").classList.add("invisible");
}

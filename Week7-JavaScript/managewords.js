"use strict";
var add_submit_button = document.getElementById("new_submit_button");
var input_words = document.getElementById("new_word");
var input_definition = document.getElementById("def_new_word");
var input_speech = document.getElementById("def_new_word")
input_words.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
input_definition.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
function form_validation(form)
{
  if (document.getElementById("new_word").value === "")
  {
    window.alert("Please input  the word you want add");
    form.new_word.focus();
    return true;
  }
  else if (document.getElementById("def_new_word").value === "")
  {
    window.alert("Please input  the definition you want add");
    form.definition.focus();
    return true;
  }
  else
  {
    return false;
  }
}

function find_duplicate()
{
  
}

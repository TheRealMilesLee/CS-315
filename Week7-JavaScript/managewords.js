"use strict";
var add_submit_button = document.getElementById("new_submit_button");
var input_words = document.getElementById("new_word");
var input_definition = document.getElementById("def_new_word");
var input_speech = document.getElementById("speech");
var input_new_speech = document.getElementById("new_part_speech");
input_words.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
input_speech.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
input_speech.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
input_new_speech.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
input_definition.onchange = function ()
{
  add_submit_button.disabled = form_validation(this);
}
function form_validation(form)
{
  if (input_words.value === "")
  {
    window.alert("Please input  the word you want add");
    form.new_word.focus();
    return true;
  }
  else if (input_speech.value === "" && input_new_speech.value === "")
  {
    window.alert("Have you check your butthole?");
    return true;
  }
  else if (input_definition.value === "")
  {
    window.alert("Please input  the definition you want add");
    return true;
  }
  else
  {
    return false;
  }
}

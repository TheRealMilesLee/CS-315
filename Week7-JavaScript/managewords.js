"use strict";
var add_word_section = document.getElementById("add_word");
var add_submit_button = document.getElementById("new_submit_button");
var input_words = document.getElementById("new_word");
var input_definition = document.getElementById("def_new_word");
var input_speech = document.getElementById("speech");
var input_new_speech = document.getElementById("new_part_speech");
var del_word_section = document.getElementById("del_word");
var del_submit_button = document.getElementById("del_submit")
var del_select_choice = document.getElementsByName("choice_to_delete[]")
window.onchange = function ()
{
  input_words.onchange = clear_delete;
  input_definition.onchange = clear_delete;
  input_speech.onchange = clear_delete;
  input_new_speech.onchange = clear_delete;
  del_select_choice.onchange = clear_add;
}
add_word_section.onchange = function ()
{
  add_submit_button.disabled = form_validation_add(this);
}
del_word_section.onchange = function ()
{
  del_submit_button.disabled = form_validation_delete(this);
}
function form_validation_add()
{
  if (input_words.value === "")
  {
    window.alert("Please input  the word you want add");
    input_words.focus();
    return true;
  }
  else if (input_speech.value === "" && input_new_speech.value === "")
  {
    window.alert("Please input the speech either by select the current or input a new one");
    input_speech.focus();
    return true;
  }
  else if (input_definition.value === "")
  {
    window.alert("Please input  the definition you want add");
    input_definition.focus();
    return true;
  }
  else
  {
    return false;
  }
}

function form_validation_delete()
{
  if (del_select_choice.value === "")
  {
    return true;
  }
  else
  {
    return false;
  }
}

function clear_add()
{
  input_words.value = "";
  input_definition.value = "";
  input_speech.value = "";
  input_new_speech.value = "";
}

function clear_delete()
{
  del_select_choice.checked = false;
}


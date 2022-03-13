"use strict";
var add_submit_button = document.getElementById("new_submit_button");
var input_words = document.getElementById("new_word");
var input_definition = document.getElementById("def_new_word");
var input_speech = document.getElementById("speech");
var input_new_speech = document.getElementById("new_part_speech");
var del_submit_button = document.getElementById("del_submit")
var del_select_choice = document.getElementsByName("choice_to_delete[]")
window.onchange = function ()
{
  add_submit_button.disabled = form_validation_add(this);
  del_submit_button.disabled = form_validation_delete(this);
}

function form_validation_add(form)
{
  if (input_words.value === "")
  {
    window.alert("Please input  the word you want add");
    form.new_word.focus();
    return true;
  }
  else if (input_speech.value === "" && input_new_speech.value === "")
  {
    window.alert("Please input the speech either by select the current or input a new one");
    form.speech.focus();
    return true;
  }
  else if (input_definition.value === "")
  {
    window.alert("Please input  the definition you want add");
    form.def_new_word.focus();
    return true;
  }
  else
  {
    return false;
  }
}

function form_validation_delete(form)
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

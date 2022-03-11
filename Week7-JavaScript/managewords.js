"use strict";
var add_submit_button = document.getElementById("new_submit_button");
add_submit_button.onclick = function ()
{
  return form_validation(this);
}
function form_validation(form)
{
  if (document.getElementById("new_word").value === "")
  {
    window.alert("Please input  the word you want add");
    form.new_word.focus();
    return false;
  }
  else if (document.getElementById("def_new_word").value === "")
  {
    window.alert("Please input  the definition you want add");
    form.definition.focus();
    return false;
  }
}

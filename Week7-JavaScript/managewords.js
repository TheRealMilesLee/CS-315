/**
 * @description A program to manage the word list for the GRE quiz
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 18.20.13 Release
 */
"use strict";
let add_word_section = document.getElementById("add_word");
let add_submit_button = document.getElementById("new_submit_button");
let input_words = document.getElementById("new_word");
let input_definition = document.getElementById("def_new_word");
let input_speech = document.getElementById("speech");
let input_new_speech = document.getElementById("new_part_speech");
let del_word_section = document.getElementById("del_word");
let del_submit_button = document.getElementById("del_submit");
let del_select_choice = document.getElementsByName("choice_to_delete[]");
let paired_array = document.getElementsByTagName("span")

/**
 * This is to find the duplicate in the entry
 */
window.onchange = function ()
{
  if (input_words.value !== "" && input_speech.value !== "")
  {
    let compare_string = " " + input_words.value + input_speech.value;
    find_duplicate(compare_string);
  }
  else if (input_words.value !== "" && input_new_speech.value !== "")
  {
    let compare_string = " " +  input_words.value + input_new_speech.value;
    find_duplicate(compare_string);
  }
  else if (input_words.value !== "" && input_new_speech.value !== ""
    && input_speech.value !== "")
  {
    let compare_string = " " +  input_words.value + input_new_speech.value;
    find_duplicate(compare_string);
  }
  else
  {
    console.log("Waiting for fill");
  }
}

/**
 * This is control the add section for validation
 */
add_word_section.onchange = function ()
{
  input_words.value.replace("<", "&lt;");
  input_new_speech.value.replace("<", "&lt;");
  input_definition.value.replace("<", "&lt;");
  clear_delete();
  add_submit_button.disabled = form_validation_add(this);
}

/**
 * This is control the delete section for validation
 */
del_word_section.onchange = function ()
{
  clear_add();
  del_submit_button.disabled = form_validation_delete(this);
}

/**
 * This function is to determine the add section is empty or not
 * @returns true if is empty
 */
function form_validation_add()
{
  if (input_words.value === "")
  {
    window.confirm("Please input  the word you want add");
    input_words.focus();
    return true;
  }
  else if (input_speech.value === "" && input_new_speech.value === "")
  {
    window.confirm("Please input the speech either by select the current or input a new one");
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

/**
 * This function is to determine whether the checkbox is checked or not
 * @returns true if the delete check box is empty, return false if the checkbox is not empty
 */
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

/**
 * This function is to clean the addition
 */
function clear_add()
{
  input_words.value = "";
  input_definition.value = "";
  input_speech.value = "";
  input_new_speech.value = "";
}

/**
 * This function is to clear the delete section
 */
function clear_delete()
{
  let index = 0;
  while (index < del_select_choice.length)
  {
    del_select_choice[index].checked = false;
    del_select_choice[index].value = "";
    index++;
  }
}

/**
 * This function is to find the duplication
 * @param {string} compare_string is the string that user input. Contains word and speech
 */
function find_duplicate(compare_string)
{
  let word_array = new Array();
  let index = 0;
  while (index < paired_array.length)
  {
    word_array.push(paired_array[index].innerHTML);
    index++;
  }
  let split_array = new Array();
  for (let index = 0; index < word_array.length; index++)
  {
    let temp_array = word_array[index].split("\t");
    split_array.push(temp_array);
  }
  console.log(compare_string);
    for (let index = 0; index < split_array.length; index++)
    {
      let compare_dict = split_array[index][0] + split_array[index][1];
      console.log(compare_dict);
      if (compare_dict === compare_string)
      {
        window.alert(" The entry you entered is already exists!");
        clear_add()
      }
    }
}

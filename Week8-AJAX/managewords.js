/**
 * @description A program to manage the word list for the GRE quiz
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 18.20.13 Release
 */
"use strict";
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
// Get the element by using the tag name
function get_by_tag(tag)
{
  return document.getElementsByTagName(tag);
}

/**
 * This is control the add section for validation
 */
get_by_id("add_word").onchange = function ()
{
  clear_delete();
  new_word_validate();
  speech_validate();
  new_definition_validate()
  let word_with_part = get_by_id("new_word").value + get_by_id("speech").value;
  get_by_id("add_button").disabled = form_validation_add();
  duplicate_validation(word_with_part);
}

/**
 * This is control the delete section for validation
 */
get_by_id("del_word").onchange = function ()
{
  clear_add();
  get_by_id("del_button").disabled = form_validation_delete();
};

/**
 * This function is to validate the input word
 */
function new_word_validate()
{
  let regex_word = new RegExp("^[a-z]+$");
  if (!regex_word.test(get_by_id("new_word").value))
  {
    get_by_id("prompt_user_validate_word").style["font-size"] = "10px";
    get_by_id("prompt_user_validate_word").style["font-style"] ="italic";
    get_by_id("prompt_user_validate_word").innerHTML = "Word should only contain a-z";
    clear_add();
  }
  else
  {
    get_by_id("prompt_user_validate_word").style["color"] = "green";
    get_by_id("prompt_user_validate_word").innerHTML = "&check;";
  }
};

function new_definition_validate()
{
  if (get_by_id("def_new_word").value !== "")
  {
    get_by_id("prompt_user_validate_def").style["color"] = "green";
    get_by_id("prompt_user_validate_def").innerHTML = "&check;";
  }
}
function speech_validate()
{
  if (get_by_id("speech").value !== "")
  {
    get_by_id("prompt_user_validate_speech").style["color"] = "green";
    get_by_id("prompt_user_validate_speech").innerHTML = "&check;";
  }
}



/**
 * This is to find the duplicate in the entry
 */
function duplicate_validation(word_with_part) {
  if (get_by_id("new_word").value !== "" && get_by_id("speech").value !== "") {
    find_duplicate(word_with_part);
  }
}
/**
 * This function is to determine the add section is empty or not
 * @returns true if is empty
 */
function form_validation_add()
{
  if (get_by_id("new_word").value === ""
    && get_by_id("speech").value === ""
    && get_by_id("def_new_word").value === "")
  {
    return true;
  }
  else if (get_by_id("new_word").value === "")
  {
    window.confirm("Please input  the word you want add");
    get_by_id("new_word").focus();
    return true;
  }
  else if (get_by_id("speech").value === "")
  {
    window.confirm("Please input the speech");
    get_by_id("speech").focus();
    return true;
  }
  else if (get_by_id("def_new_word").value === "")
  {
    window.alert("Please input  the definition you want add");
    get_by_id("def_new_word").focus();
    return true;
  }
  else {
    return false;
  }
}

// /**
//  * This function is to determine whether the checkbox is checked or not
//  * @returns true if the delete check box is empty,
//  * return false if the checkbox is not empty
//  */
// function form_validation_delete()
// {
//   let index = 0;
//   let empty = true;
//   let paired_array = get_by_name("choice_to_delete[]");
//   while (index < paired_array.length)
//   {
//     if (paired_array[index].checked === true)
//     {
//       empty = false;
//     }
//     index++;
//   }
//   return empty;
// }

/**
 * This function is to clean the addition
 */
function clear_add()
{
  get_by_id("new_word").value = "";
  get_by_id("def_new_word").value = "";
  get_by_id("speech").value = "";
}

/**
 * This function is to clear the delete section
 */
function clear_delete()
{
  let index = 0;
  while (index < get_by_name("choice_to_delete[]").length)
  {
    get_by_name("choice_to_delete[]")[index].checked = false;
    index++;
  }
}

// /**
//  * This function is to find the duplication
//  * @param {string} compare_string is the string that user input.
//  */
// function find_duplicate(compare_string)
// {
//   let word_array = [];
//   let index = 0;
//   while (index < get_by_tag("span").length)
//   {
//     word_array.push(get_by_tag("span")[index].innerHTML);
//     index++;
//   }
//   let split_array = [];
//   for (let loop = 0; loop < word_array.length; loop++)
//   {
//     let temp_array = word_array[loop].split("\t");
//     split_array.push(temp_array);
//     loop++;
//   }
//   for (let looptimes = 0; looptimes < split_array.length; looptimes++)
//   {
//     let compare_dict = split_array[looptimes][0] + split_array[looptimes][1];
//     if (compare_dict === compare_string)
//     {
//       window.alert(" The entry you entered is already exists!");
//       clear_add();
//     }
//     looptimes++;
//   }
// }

// function load_with_promise()
// {
//   fetch("words.txt")
//     .then((payload) => payload.text())
//     .then(function (response)
//     {
//       get_by_id("delete_section_limit_window").innerHTML = response;
//     });
// }


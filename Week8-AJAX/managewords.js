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
 * This is to find the duplicate in the entry
 */
window.onchange = function ()
{
  let word_with_part = get_by_id("new_word").value + get_by_id("speech").value;
  get_by_id("add_button").disabled = form_validation_add();
  // if (get_by_id("new_word").value !== ""
  //   && get_by_id("speech").value !== "")
  // {
  //   find_duplicate(word_with_part);
  // }
  // else if (get_by_id("new_word").value !== ""
  //             && get_by_id("new_speech").value !== "")
  // {
  //     find_duplicate(word_with_new_part);
  // }
  // else if (get_by_id("new_word").value !== ""
  //   && get_by_id("new_speech").value !== ""
  //   && get_by_id("speech").value !== "")
  // {
  //   find_duplicate(word_with_new_part);
  // }
  // get_by_id("del_button").disabled = form_validation_delete();
  // let speech = get_by_id("speech");
  // speech.onchange = function ()
  // {
  //   get_by_id("new_speech").value = "";
  // };
  // let new_speech = get_by_id("new_speech");
  // new_speech.onchange = function ()
  // {
  //   get_by_id("speech").value = "";
  //   let regex_speech = new RegExp("^[a-z]+$");
  //   if (!regex_speech.test(get_by_id("new_speech").value))
  //   {
  //     window.alert("Please only input the lowercase speech");
  //     clear_add();
  //   }
  // };
};

// /**
//  * This is control the add section for validation
//  */
// get_by_id("add_word").onchange = function ()
// {
//   clear_delete();
// };
// get_by_id("new_word").onchange = function ()
// {
//   let regex_word = new RegExp("^[a-z]+$");
//   if (!regex_word.test(get_by_id("new_word").value))
//   {
//     window.alert("Please only input the lowercase words");
//     clear_add();
//   }
// };
// get_by_id("new_speech").onchange = function ()
// {
//   let regex_speech = new RegExp("^[a-z]+$");
//   if (!regex_speech.test(get_by_id("new_speech").value))
//   {
//     window.alert("Please only input the lowercase speech");
//     clear_add();
//   }
// };
// /**
//  * This is control the delete section for validation
//  */
// get_by_id("del_word").onchange = function ()
// {
//   clear_add();
// };



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

// /**
//  * This function is to clean the addition
//  */
// function clear_add()
// {
//   get_by_id("new_word").value = "";
//   get_by_id("def_new_word").value = "";
//   get_by_id("speech").value = "";
//   get_by_id("new_speech").value = "";
// }

// /**
//  * This function is to clear the delete section
//  */
// function clear_delete()
// {
//   let index = 0;
//   while (index < get_by_name("choice_to_delete[]").length)
//   {
//     get_by_name("choice_to_delete[]")[index].checked = false;
//     index++;
//   }
// }

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


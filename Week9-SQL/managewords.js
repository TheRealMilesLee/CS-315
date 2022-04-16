/**
 * @description A program to manage the word list for the GRE quiz
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 18.20.13 Release
 */
"use strict";
let xhr = null; // a global variable to prevent race
// Get the element by using the id
const get_by_id = (id) => { return document.getElementById(id); };
// Get the element by using the name
let get_by_name = (name) => { return document.getElementsByName(name); };
// Get the ele
let get_by_tag = (tag) => { return document.getElementsByTagName(tag); };

window.onload = function ()
{
  create_new_div_entry();
}
get_by_id("add_button").onclick = function ()
{
  let new_word = get_by_id("new_word").value;
  let new_speech = get_by_id("speech").value;
  let new_definition = get_by_id("def_new_word").value;
  for (let index = 0; index < new_definition.length; index++)
  {
    if (new_definition[index] === "&")
    {
      new_definition = new_definition.replace("&", "π");
    }
    else if (new_definition[index] === "+")
    {
      new_definition = new_definition.replace("+", "√");
    }
  }
  add_new_entry(new_word, new_speech, new_definition);
  clean_previous_entry();
  clear_add();
  new_word_validate();
  speech_validate();
  new_definition_validate();
};


/**
 * This is control the add section for validation
 */
get_by_id("add_word").onchange = function ()
{
  new_word_validate();
  speech_validate();
  new_definition_validate();
  let new_word = get_by_id("new_word").value;
  let new_speech = get_by_id("speech").value;
  let new_definition = get_by_id("def_new_word").value;
  for (let index = 0; index < new_definition.length; index++)
  {
    if (new_definition[index].charCodeAt() > 127)
    {
      get_by_id("definition_prompt").classList.remove("warning_sign_style");
      get_by_id("definition_prompt").classList.remove("pass_sign_style");
      get_by_id("definition_prompt").classList.add("warning_prompt_style");
      get_by_id("definition_prompt").innerHTML =
        "Please only input English character and symbols";
      clear_add();
      new_word_validate();
      speech_validate();
    }
  }
  let word_with_part = new_word + new_speech ;
  get_by_id("add_button").disabled = form_validation_add();
  duplicate_validation(word_with_part);
};

get_by_id("search_to_delete").onkeyup = function ()
{
  clean_previous_entry();
  let search_string = get_by_id("search_to_delete").value;
  load_words_from_disk(search_string);
}

get_by_id("delete_word").onchange = function ()
{
    get_by_id("delete_submit").disabled = form_validation_delete();
}

get_by_id("delete_submit").onclick = function ()
{
  delete_word_button();
}
/**
 * This function is to validate the input word
 */
function new_word_validate()
{
  let regex_word = new RegExp("^[a-z]+$");
  if (get_by_id("new_word").value == "")
  {
    get_by_id("word_prompt").classList.remove("pass_sign_style");
    get_by_id("word_prompt").classList.add("warning_sign_style");
    get_by_id("word_prompt").innerHTML = "&excl;";
  }
  else if (!regex_word.test(get_by_id("new_word").value))
  {
    get_by_id("word_prompt").classList.remove("pass_sign_style");
    get_by_id("word_prompt").classList.add("warning_prompt_style");
    get_by_id("word_prompt").innerHTML =
      "Only lowercase alphabet letters is accepted";
    clear_add();
  }
  else
  {
    get_by_id("word_prompt").classList.remove("warning_sign_style");
    get_by_id("word_prompt").classList.remove("warning_prompt_style");
    get_by_id("word_prompt").classList.add("pass_sign_style");
    get_by_id("word_prompt").innerHTML = "&check;";
  }
};

/**
 * This function validate the speech
 */
function speech_validate()
{
  if (get_by_id("speech").value !== "")
  {
    get_by_id("speech_prompt").classList.remove("warning_sign_style");
    get_by_id("speech_prompt").classList.add("pass_sign_style");
    get_by_id("speech_prompt").innerHTML = "&check;";
  }
  else
  {
    get_by_id("speech_prompt").classList.remove("pass_sign_style");
    get_by_id("speech_prompt").classList.add("warning_sign_style");
    get_by_id("speech_prompt").innerHTML = "&excl;";
  }
}


/**
 * This function validate the new definition
 */
function new_definition_validate()
{
  if (get_by_id("def_new_word").value !== "")
  {
    get_by_id("definition_prompt").classList.remove("warning_sign_style");
    get_by_id("definition_prompt").classList.remove("warning_prompt_style");
    get_by_id("definition_prompt").classList.add("pass_sign_style");
    get_by_id("definition_prompt").innerHTML = "&check;";
  }
  else
  {
    get_by_id("definition_prompt").classList.remove("warning_sign_style");
    get_by_id("definition_prompt").classList.remove("pass_sign_style");
    get_by_id("definition_prompt").classList.add("warning_prompt_style");
    get_by_id("definition_prompt").innerHTML = "&excl;";
   }
}


/**
 * This is to find the duplicate in the entry
 */
function duplicate_validation(word_with_part)
{
  if (get_by_id("new_word").value !== "" && get_by_id("speech").value !== "")
  {
    find_duplicate(word_with_part);
  }
}

/**
 * This function is to determine the add section is empty or not
 * @returns true if is empty
 */
function form_validation_add()
{
  if (get_by_id("new_word").value === "" &&
      get_by_id("speech").value === "" &&
      get_by_id("def_new_word").value === "")
  {
    return true;
  }
  else if (get_by_id("new_word").value === "")
  {
    get_by_id("new_word").focus();
    return true;
  }
  else if (get_by_id("speech").value === "")
  {
    get_by_id("speech").focus();
    return true;
  }
  else if (get_by_id("def_new_word").value === "")
  {
    get_by_id("def_new_word").focus();
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
  get_by_id("new_word").value = "";
  get_by_id("speech").value = "";
  get_by_id("def_new_word").value = "";
}


/**
 * This function is to find the duplication
 * @param {string} compare_string is the string that user input.
 */
function find_duplicate(compare_string)
{
  let word_array;
  let split_array = [];
  let index = 0;
  while (index < get_by_tag("span").length)
  {
    word_array = get_by_tag("span")[index].innerHTML.split("\t");
    split_array.push(word_array);
    index++;
  }
  for (let looptimes = 0; looptimes < split_array.length; looptimes++)
  {
    let compare_dict = split_array[looptimes][0] + split_array[looptimes][1];
    if (compare_dict === compare_string)
    {
      window.alert(" The entry you entered is already exists!");
      clear_add();
      new_word_validate();
      speech_validate();
      new_definition_validate();
    }
  }
}

/**
 * This function is to get the file from the disk
 */
function load_words_from_disk(search_string)
{
  let response = [];
  xhr = new XMLHttpRequest();
  const url = "get_words.php?search=" + search_string;
  xhr.open("GET", url, true);
  xhr.onload = function ()
  {
    const results = JSON.parse(xhr.responseText);
    for (let index = 0; index < results.length; index++)
    {
      response.push(results[index]);
    }
    display(response);
  };
  xhr.send();
}

function display(response)
{
  for (let index = 0; index < response.length; index++)
  {
    let checkbox = document.createElement("input");
    checkbox.setAttribute("type", "checkbox");
    checkbox.setAttribute("name", "choice_to_delete[]");
    checkbox.setAttribute("value", index);
    let new_word_line = document.createElement("span");
    new_word_line.innerHTML =
      response[index]["word"] + "\t" +
      response[index]["part"] + "\t" +
      response[index]["definition"];
    new_word_line.classList.add("word_list");
    new_word_line.setAttribute("id", index);
    let original_div = get_by_id("display");
    let newline = document.createElement("p");
    original_div.appendChild(checkbox);
    original_div.appendChild(new_word_line);
    original_div.appendChild(newline);
  }
}

// function add_new_entry(new_word, new_speech, new_definition)
// {
//   xhr = new XMLHttpRequest();
//   const url = "put_word.php";
//   const data_array = [new_word, new_speech, new_definition];
//   const json_string = `payload=${ JSON.stringify(data_array) }`;
//   xhr.open("POST", url);
//   xhr.setRequestHeader
//     ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
//   xhr.send(json_string);
// }

function clean_previous_entry()
{
  let original_text = get_by_id("display");
  original_text.innerHTML = "";
}

function create_new_div_entry()
{
  let display_section = document.createElement("div");
  display_section.setAttribute("id", "display");
  let father_node = get_by_id("delete_word");
  father_node.appendChild(display_section);
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

/**
 * This function is to clean the addition
 */
function clear_add()
{
  get_by_id("new_word").value = "";
  get_by_id("def_new_word").value = "";
  get_by_id("speech").value = "";
  get_by_id("new_part_speech").value = "";
}

/**
 * This function is to determine whether the checkbox is checked or not
 * @returns true if the delete check box is empty,
 * return false if the checkbox is not empty
 */
function form_validation_delete()
{
  let index = 0;
  let empty = true;
  let delete_choice = get_by_name("choice_to_delete[]");

  while (index < delete_choice.length)
  {
    if (delete_choice[index].checked === true)
    {
      empty = false;
    }
    index++;
  }
  return empty;
}


function delete_word_button()
{
  let index = 0;
  let lines_to_delete = [];
  let words_to_delete = [];
  let selected_word = get_by_name("choice_to_delete[]");
  while (index < selected_word.length)
  {
    if (selected_word[index].checked === true)
    {
      lines_to_delete.push(get_by_id(index).innerHTML);
    }
    index++;
  }
  lines_to_delete.forEach((elements) =>
  {
    let split_array = elements.split("\t");
    words_to_delete.push(split_array[0]);
  })
  xhr = new XMLHttpRequest();
  const delete_string = `delete_word=${JSON.stringify(words_to_delete)}`;
  xhr.open("POST", "delete_word.php");
  xhr.setRequestHeader
    ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
  xhr.onload = function ()
  {
    console.log(delete_string);
  }
  xhr.send(delete_string);
}

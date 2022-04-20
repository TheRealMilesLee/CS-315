/**
 * @description A program to manage the word list for the GRE quiz
 * @author Hengyi Li
 * @copyright Copyright (c). 2022 Hengyi Li. All rights reserved
 * @version 39.20.13 Release
 */
"use strict";
let xhr = null; // a global variable to prevent race
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

/**
 * This function is to load with a empty div
 */
window.onload = function ()
{
  create_new_div_entry();
};
get_by_id("add_button").onclick = function ()
{
  let new_word = get_by_id("new_word").value;
  let new_speech = get_by_id("speech").value;
  let new_definition = get_by_id("def_new_word").value;
  let index = 0;
  while (index < new_definition.length)
  {
    if (new_definition[index] === "&")
    {
      new_definition = new_definition.replace("&", "π");
    }
    else if (new_definition[index] === "+")
    {
      new_definition = new_definition.replace("+", "√");
    }
    index += 1;
  }
  add_new_entry(new_word, new_speech, new_definition);
  clear_add();
  clear_delete();
  get_by_id("search_delete").value = "";
  clean_previous_entry();
  new_word_validate();
  speech_validate();
  new_definition_validate();
};

/**
 * This is control the add section for validation
 */
get_by_id("add_word").onchange = function ()
{
  clear_delete();
  clean_previous_entry();
  get_by_id("search_delete").value = "";
  new_word_validate();
  speech_validate();
  new_definition_validate();
  let new_word = get_by_id("new_word").value;
  let new_speech = get_by_id("speech").value;
  let new_definition = get_by_id("def_new_word").value;
  let index = 0;
  while (index < new_definition.length)
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
    index += 1;
  }
  get_by_id("add_button").disabled = form_validation_add();
  duplicate_validation(new_word, new_speech);
};

get_by_id("search_delete").onkeyup = function ()
{
  clean_previous_entry();
  let search_string = get_by_id("search_delete").value;
  load_words_from_disk(search_string);
};

get_by_id("delete_word").onchange = function ()
{
  clear_add();
  new_word_validate();
  speech_validate();
  new_definition_validate();
  get_by_id("delete_submit").disabled = form_validation_delete();
};

get_by_id("delete_submit").onclick = function ()
{
  delete_word_button();
  clean_previous_entry();
  get_by_id("search_delete").value = "";
};

/**
 * This function is to validate the input word
 */
function new_word_validate()
{
  let regex_word = new RegExp("^[a-z]+$");
  if (get_by_id("new_word").value === "")
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
}

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
function duplicate_validation(new_word, new_speech)
{
  if (new_word !== "" && new_speech !== "")
  {
    find_duplicate(new_word, new_speech);
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
function find_duplicate(words, definition)
{
  xhr = new XMLHttpRequest();
  const search_string = [words, definition];
  const duplicate_string = `duplicate=${JSON.stringify(search_string)}`;
  xhr.open("POST", "add_word.php");
  xhr.setRequestHeader
    ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
  xhr.onload = function ()
  {
    let duplicate_result = JSON.parse(xhr.responseText);
    console.log(duplicate_result);
    if (duplicate_result === true)
    {
      window.alert(" The entry you entered is already exists!");
      clear_add();
      new_word_validate();
      speech_validate();
      new_definition_validate();
    }
  };
  xhr.send(duplicate_string);
}

/**
 * This function is to get the file from the disk
 */
function load_words_from_disk(search_string)
{
  if (xhr)
  {
    xhr.abort();
    xhr = null;
  }
  if (search_string !== "")
  {
    let response = [];
    xhr = new XMLHttpRequest();
    const url = "get_words.php?search=" + search_string;
    console.log(url);
    xhr.open("GET", url, true);
    xhr.onload = function ()
    {
      const results = JSON.parse(xhr.responseText);
      let index = 0;
      while (index < results.length)
      {
        response.push(results[index]);
        index += 1;
      }
      display(response);
    };
    xhr.send();
  }
}

function display(response)
{
  let index = 0;
  while (index < response.length)
  {
    let checkbox = document.createElement("input");
    checkbox.setAttribute("type", "checkbox");
    checkbox.setAttribute("name", "choice_to_delete[]");
    checkbox.setAttribute("value", index);
    let new_word_line = document.createElement("span");
    new_word_line.innerHTML =
      response[index].word + "\t" +
      response[index].part + "\t" +
      response[index].definition;
    new_word_line.classList.add("word_list");
    new_word_line.setAttribute("id", index);
    let original_div = get_by_id("display");
    let newline = document.createElement("p");
    original_div.appendChild(checkbox);
    original_div.appendChild(new_word_line);
    original_div.appendChild(newline);
    index += 1;
  }
}

function add_new_entry(new_word, new_speech, new_definition)
{
  if (xhr)
  {
    xhr.abort();
    xhr = null;
  }
  xhr = new XMLHttpRequest();
  const data_array = [new_word, new_speech, new_definition];
  const new_entry = `new_entry=${ JSON.stringify(data_array) }`;
  console.log(new_entry);
  xhr.open("POST", "add_word.php");
  xhr.setRequestHeader
    ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
  xhr.send(new_entry);
}

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
    index += 1;
  }
  get_by_id();
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
    index += 1;
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
    index += 1;
  }
  lines_to_delete.forEach(function (elements) {
    let split_array = elements.split("\t");
    words_to_delete.push(split_array[0]);
    words_to_delete.push(split_array[1]);
  });

  xhr = new XMLHttpRequest();
  const delete_string = `delete_word=${JSON.stringify(words_to_delete)}`;
  xhr.open("POST", "delete_word.php");
  xhr.setRequestHeader
    ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
  xhr.send(delete_string);
}

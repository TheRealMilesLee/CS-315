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
  load_words_from_disk();
};

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
  load_words_from_disk();
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
      get_by_id("prompt_user_validate_def").innerHTML =
        "Only lowercase alphabet letters is accepted";
      get_by_id("prompt_user_validate_def").style["color"] = "red";
      get_by_id("prompt_user_validate_def").style["font-size"] = "10px";
      clear_add();
      new_word_validate();
      speech_validate();
    }
  }

  let word_with_part = new_word + new_speech ;
  get_by_id("add_button").disabled = form_validation_add();
  duplicate_validation(word_with_part);
};

/**
 * This function is to validate the input word
 */
function new_word_validate()
{
  let regex_word = new RegExp("^[a-z]+$");
  if (get_by_id("new_word").value == "")
  {
    get_by_id("prompt_user_validate_word").style["color"] = "red";
    get_by_id("prompt_user_validate_word").style["font-size"] = "20px";
    get_by_id("prompt_user_validate_word").style["font-style"] = "italic";
    get_by_id("prompt_user_validate_word").innerHTML = "&excl;";
  }
  else if (!regex_word.test(get_by_id("new_word").value))
  {
    get_by_id("prompt_user_validate_word").style["color"] = "red";
    get_by_id("prompt_user_validate_word").style["font-size"] = "10px";
    get_by_id("prompt_user_validate_word").style["font-style"] = "italic";
    get_by_id("prompt_user_validate_word").innerHTML =
        "Only lowercase alphabet letters is accepted";
    clear_add();
  }
  else
  {
    get_by_id("prompt_user_validate_word").style["color"] = "green";
    get_by_id("prompt_user_validate_word").innerHTML = "&check;";
  }
};
/**
 * This function validate the speech
 */
function speech_validate()
{
  if (get_by_id("speech").value !== "")
  {
    get_by_id("prompt_user_validate_speech").style["color"] = "green";
    get_by_id("prompt_user_validate_speech").innerHTML = "&check;";
  }
  else
  {
    get_by_id("prompt_user_validate_speech").style["color"] = "red";
    get_by_id("prompt_user_validate_speech").innerHTML = "&excl;";
  }
}


/**
 * This function validate the new definition
 */
function new_definition_validate()
{
  if (get_by_id("def_new_word").value !== "")
  {
    get_by_id("prompt_user_validate_def").style["color"] = "green";
    get_by_id("prompt_user_validate_def").innerHTML = "&check;";
  }
  else
  {
    get_by_id("prompt_user_validate_def").style["color"] = "red";
    get_by_id("prompt_user_validate_def").innerHTML = "&excl;";
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
function load_words_from_disk()
{
  let response = [];
  xhr = new XMLHttpRequest();
  const url = `get_words.php`;
  xhr.open("GET", url, true);
  xhr.onload = function ()
  {
    const results = JSON.parse(xhr.responseText);
    results.forEach((element) => response.push(element));
    display(response);
  };
  xhr.send();
}

function display(response)
{
  create_new_div_entry();
  for (let index = 0; index < response.length; index++)
  {
    let new_word_line = document.createElement("span");
    new_word_line.innerHTML =
      response[index][0] + "\t" +
      response[index][1] + "\t" +
      response[index][2];
    new_word_line.classList.add("word_list");
    let original_div = get_by_id("display");
    let newline = document.createElement("p");
    original_div.appendChild(new_word_line);
    original_div.appendChild(newline);
  }
}

function add_new_entry(new_word, new_speech, new_definition)
{
  const xhr = new XMLHttpRequest();
  const url = "put_word.php";

  const data_array = [new_word, new_speech, new_definition];
  const json_string = `payload=${ JSON.stringify(data_array) }`;
  console.log(json_string);
  xhr.open("POST", url);
  xhr.setRequestHeader
    ("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
  xhr.send(json_string);
}

function clean_previous_entry()
{
  let original_text = get_by_id("display");
  original_text.remove();
}

function create_new_div_entry()
{
  let display_section = document.createElement("div");
  display_section.setAttribute("id", "display");
  let father_node = get_by_id("display_word");
  father_node.appendChild(display_section);
}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> Manage Words </title>
  <meta name="author" content="Hengyi Li" />
  <link rel="stylesheet" href="managewords.css" />
</head>

<body>
  <div id="intro_header">
    <h1 id="word_manager_head"> Word Manager </h1>
    <p class="chatty_talking">
      This is the Zelda' s GRE vocabulary manager, welcome. <br />
      Go to the left and fill in the blank to add the word, go down below
      and select your choice to delete the words. <br />
      Have fun.
    </p>
  </div>
  <div id="add_word">
    <!-- Add word section -->
    <p class="sub-title"> Add a new word </p>
    <!-- Add the new word -->
    <div id="new_word">
      <p>
        <label for="new_word"> What's the word? </label>
        <input type="text" id="new_word" name="new_word" />
      </p>
    </div>
    <!-- Add the part of speech -->
    <div id="new_id">
      <p>
        <label for="speech"> What's the part of speech of the word? </label>
        <select name="speech" id="speech">
          <option value=""> Make a choice </option>
          <option value="noun"> noun </option>
          <option value="adjective"> adjective </option>
          <option value="adverb"> adverb </option>
          <option value="verb"> verb </option>
        </select>
      </p>
    </div>
    <!-- Add the definition -->
    <div id="new_definition">
      <p>
        <label for="def_new_word">What's the definition of the word?</label>
        <input type='text' id="def_new_word" name="def_new_word" />
      </p>
    </div>
    <!-- Add word submit button -->
    <div id="add_submit">
      <p>
        <input type="submit" id="add_button" value="Add word" name="submit" disabled />
      </p>
    </div>
  </div>
  <!-- Delete word section -->
  <div id="del_word">
    <p class="sub-title"> Delete a word </p>
    <p id="delete_section_limit_window"> This is the delete part </p>
    <!-- Delete word button -->
    <div id="del_submit">
      <p>
        <input type='submit' id="del_submit" value='Confirm to delete' name='delete' disabled />
      </p>
    </div>
  </div>
  <script src=" managewords.js"></script>
</body>

</html>

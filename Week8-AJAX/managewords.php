<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title> Manage Words </title>
    <meta name="author" content="Hengyi Li" />
    <link rel="stylesheet" href="managewords.css" />
  </head>
  <body>
    <form method="post" action="managewords.php">
      <div class="header_topic_left">
        <h1 class="header_topic"> Word Manager </h1>
        <p class="chatty_talking">
          This is the Zelda' s GRE vocabulary manager, welcome.
          <br />
          Go to the left and fill in the blank to add the word, go down below
          and select your choice to delete the words.
          <br />
          Have fun.
        </p>
      </div>
      <div id="add_word">
        <p class="sub-title"> Add a new word </p>
        <p>
          <label for="new_word"> What's the word? </label>
          <input type="text" id="new_word" name="new_word" />
        </p>
        <p>
          <label for="speech"> What's the part of speech of the word? </label>
          <select name="speech" id="speech">
            <option value=""> Make a choice</option>
            <?php
            $part_of_speech_list
              = file(PART_OF_SPEECH, FILE_IGNORE_NEW_LINES);
            array_multisort($part_of_speech_list, SORT_ASC, SORT_REGULAR);
            $index = 0;
            while ($index < count($part_of_speech_list))
            {
            ?>
              <option value="<?= $part_of_speech_list[$index] ?>">
                <?= $part_of_speech_list[$index] ?>
              </option>
            <?php
              $index++;
            }
            ?>
          </select>
        </p>
        <p>
          <label for="new_speech">
            Not found you want? Fill your own part of speech!
          </label>
          <input type="text" id="new_speech" name="new_speech" />
        </p>
        <p>
          <label for="def_new_word">What's the definition of the word?</label>
          <input type='text' id="def_new_word" name="def_new_word" />
        </p>
        <p>
          <input type="submit" id="new_submit_button" value="Add word" name="submit" disabled />
        </p>
      </div>
      <div id="del_word">
        <p class="sub-title"> Delete a word </p>
        <div class="delete_section_limit_window">
          <?php
          display(DEFINITION_FILENAME);
          ?>
        </div>
        <p>
          <input type='submit' id="del_submit" value='Confirm to delete' name='delete' disabled />
        </p>
      </div>
    </form>
    <script src=" managewords.js"></script>
  </body>
</html>

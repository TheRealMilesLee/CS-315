<?php
/**
 * A program for practicing GRE vocabulary words
 * @author Jon Beck
 * @version 27 January 2022
 */

define('HIT_COUNT_FILENAME', 'hits.txt');
define('DEFINITION_FILENAME', 'words.txt');

/**
 * read a tab-separated file of words, parts of speech, and definitions
 * and return a random line from that file
 * @param $filename a string containing the name of the file to read
 * @return one line of the file chosen at random
 */
function get_random_line($filename)
{
  $lines = file($filename, FILE_IGNORE_NEW_LINES);
  $random_index = rand(0, count($lines) - 1);
  return $lines[$random_index];
}

/**
 * read an integer from a file (or create it with 0), increment the
 * integer, and save the new value back to the file
 * return the incremented value
 * @param $filename a string containing the name of the file to read
 * @return the integer value contained in the file, after being
 * incremented
 */
function get_incremented_counter($filename)
{
  if (file_exists($filename))
  {
    $hits = trim(file_get_contents($filename));
    $hits++;
  }
  else
  {
    $hits = 1;
  }

  file_put_contents($filename, $hits . PHP_EOL, LOCK_EX);
  return $hits;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Word of the Day</title>
    <link rel="stylesheet" href="word.css" />
    <meta charset="utf-8" />
    <meta name="author" content="Jon Beck" />
  </head>

  <body>
    <h1>GRE Vocabulary Word of the Day</h1>

    <p>
      Welcome to Zelda&rsquo;s GRE vocabulary word practice. Each
      time you visit, a word and its definition will be shown.
    </p>

    <p> Your word of the day is:</p>

    <?php
      $aline = get_random_line(DEFINITION_FILENAME);
      list($word, $part_of_speech, $definition) = explode("\t", $aline);
    ?>

    <dl>
      <dt><?= $word ?></dt>
      <dd>
        <span class="partofspeech"><?= $part_of_speech ?></span>
        &mdash; <?= $definition ?>
      </dd>
    </dl>

    <p>
      This page has been accessed
      <?php $hits = get_incremented_counter(HIT_COUNT_FILENAME); ?>
      <?php if ($hits == 1): ?>
        1 time.
      <?php else: ?>
        <?= $hits ?> times.
      <?php endif; ?>
    </p>
  </body>
</html>

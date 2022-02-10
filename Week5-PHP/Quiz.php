<?php
/**
 * A program to serve a GRE vocabulary quiz
 * This program runs in two modes.
 * Mode 1: nothing has been submitted; this is the first time
 * Mode 2: this is not the first submission
 * @author Jon Beck
 * @version 1 February 2022
 */

const DEFINITION_FILENAME = 'words.txt';
const NUMBER_OF_CHOICES = 4;

/**
 * read in a tab-separated array of lines consisting of a word,
 * a part of speech, and a definition
 *
 * randomly choose one word, its part of speech, and its definition
 *
 * randomly choose (up to) n other definitions that match that part of
 * speech
 * @param $file
 * @param $number_to_get
 * @return array with element 0 an array of the word, the part of
 * speech, and the definition, and the other elements the randomly
 * chosen definitions
 */
function get_definitions($file, $number_to_get): array
{
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $random_index = array_rand($lines);
    list($word, $part, $definition) = explode("\t", $lines[$random_index]);
    unset($lines[$random_index]);

    $result = array();
    $result[] = array($word, $part, $definition);

    $matching_lines = preg_grep("/\t$part\t/", $lines);
    shuffle($matching_lines);

    $count = 0;
    while ($count < count($matching_lines) && count($result) <= $number_to_get)
    {
        $line = $matching_lines[$count];
        $result[] = explode("\t", $line)[2];
        $count++;
    }

    return $result;
}

/**
 * shuffle an array in place, preserving the key-value pairs
 * @param $array_to_shuffle
 * @return true if given an array; false otherwise
 */
function shuffle_assoc(&$array_to_shuffle): bool
{
    if (!is_array($array_to_shuffle))
    {
        return false;
    }

    $keys = array_keys($array_to_shuffle);
    shuffle($keys);
    $new_ary = array();
    foreach ($keys as $key)
    {
        $new_ary[$key] = $array_to_shuffle[$key];
    }

    $array_to_shuffle = $new_ary;
    return true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GRE Vocab Quiz</title>
    <meta name="author" content="Jon Beck" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="quiz.css" />
</head>

<body>
<h1>Zelda&rsquo;s GRE Vocabulary Quiz</h1>

<?php
if (isset($_POST) &&
    isset($_POST['word']) &&
    preg_match('|^[A-Za-z]+$|', $_POST['word']) &&
    isset($_POST['definition']) &&
    preg_match('|^[A-Za-z;( -]+|', $_POST['definition']) &&
    isset($_POST['guess']) &&
    preg_match('|^[0-9]$|', $_POST['guess']) &&
    isset($_POST['number_total']) &&
    preg_match('|^[0-9]+$|', $_POST['number_total']) &&
    isset($_POST['number_correct']) &&
    preg_match('|^[0-9]+$|', $_POST['number_correct']))
{
    $first_time = false;
    $word = $_POST['word'];
    $definition = $_POST['definition'];
    $guess = $_POST['guess'];
    $number_correct = $_POST['number_correct'];
    $number_total = $_POST['number_total'];
}
else
{
    $first_time = true;
    $word = '';
    $guess = 0;
    $number_correct = 0;
    $number_total = 0;
}
?>

<?php if (!$first_time) : ?>
    <?php if ($guess == 0) : ?>
        <h2 class="correct">Correct!</h2>
        <h3>Your score: <?= ++$number_correct ?> / <?= ++$number_total ?> </h3>
    <?php else: ?>
        <h2 class="incorrect">Incorrect!</h2>
        <p class="incorrect">
            The definition of <?= $word ?> is: <?= $definition ?>
        </p>
        <h3>Your score: <?= $number_correct ?> / <?= ++$number_total ?> </h3>
    <?php endif; ?>
<?php endif; ?>

<?php
$choices = get_definitions(DEFINITION_FILENAME, NUMBER_OF_CHOICES);
list($word, $part, $real_definition) = $choices[0];
$all_definitions = array();
$all_definitions[0] = $real_definition;
$index = 1;
while ($index < count($choices))
{
    $all_definitions[] = $choices[$index];
    $index++;
}
shuffle_assoc($all_definitions);
?>

<h2>
    <?= $word ?> &mdash;
    <span class="partofspeech"><?= $part ?></span>
</h2>

<form action="quiz.php" method="post">
    <ul id="choices">

        <?php foreach ($all_definitions as $index => $definition): ?>
            <li>
                <input type="radio" name="guess" value="<?= $index ?>" />
                <?= $definition ?>
            </li>
        <?php endforeach; ?>

    </ul>

    <input type="hidden" name="word" value="<?= $word ?>" />
    <input type="hidden" name="number_total"
           value="<?= $number_total ?>" />
    <input type="hidden" name="number_correct"
           value="<?= $number_correct ?>" />
    <input type="hidden" name="definition"
           value="<?= $real_definition ?>" />
    <button id="submit" type="submit">Submit</button>

</form>
</body>
</html>
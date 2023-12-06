<?php
// open file
$file = file_get_contents("mots7-nul.txt");
// split file into array
$words = explode("\n", $file);
// delete words that are not 7 letters long
foreach ($words as $key => $word) {
    if (strlen($word) != 8) {
        unset($words[$key]);
    }
}
// save array to file
file_put_contents("mots7.txt", implode("\n", $words));
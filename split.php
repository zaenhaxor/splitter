<?php

//biru muda
$cyan = "\033[36m"; 
$reset = "\033[0m";
function banner($cyan, $reset) {
    echo $cyan;
    echo "#########################################\n";
    echo "#           Splitter file               #\n";
    echo "#########################################\n\n";
    echo $reset;
}
function split($filenya, $parts) {
    if (!file_exists($filenya)) {
        die("File $file gak ada.\n");
    }
    $line_total = 0;
    $file = fopen($filenya, 'r');
    while (!feof($file)) {
        fgets($file);
        $line_total++;
    }
    fclose($file);

    //https://www.php.net/manual/en/function.ceil.php
    $line_per_part = ceil($line_total / $parts); 
    $file = fopen($filenya, 'r');
    if (!$file) {
        die("failed open $filenya.\n");
    }
    for ($part = 1; $part <= $parts; $part++) {
        $new_file_name = "{$part}_{$filenya}";
        $new_file = fopen($new_file_name, 'w'); 
        if (!$new_file) {
            die("failed create $new_file_name.\n");
        }
        for ($line = 0; $line < $line_per_part && !feof($file); $line++) {
            $current = fgets($file);
            fwrite($new_file, $current);
        }
        fclose($new_file); 
        echo "$new_file_name\n"; 
    }
    fclose($file); 
}
banner($cyan, $reset);
if ($argc < 3) {
    $tools = basename($argv[0]);
    die("use: php {$tools} {file} {jumlah}\n");
}
$file_name = $argv[1];
$parts = (int) $argv[2]; 

if ($parts < 1) {
    die("the number of parts must be greater than 0.\n");
}
split($file_name, $parts);

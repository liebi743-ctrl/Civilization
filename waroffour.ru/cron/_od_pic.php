<?php
$file = 'img/soc/rand/'.rand(1,38).'.jpg';
$newfile = 'img/soc/50.jpg';

if (!copy($file, $newfile)) {
    echo "не удалось скопировать $file...\n";
}
?>
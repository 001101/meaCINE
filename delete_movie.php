<?php

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

unset($tempArray[$_GET['id']]);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./index.php'); 

?>

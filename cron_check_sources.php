<?php

include ('./functions.php');

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

foreach ($tempArray as $key => $movie) {
	if ( !isset($mini_id) ){ $mini_id = $key; }
	if ( !isset($mini_time) ){ $mini_time = $movie['last_check']; }
	if ( $movie['last_check'] < $mini_time ) { $mini_time = $movie['last_check']; $mini_id = $key; }
}

$title = $tempArray[$mini_id]['title'];
$year = $tempArray[$mini_id]['year'];
$server = $tempArray[$mini_id]['server'];
$file_code = $tempArray[$mini_id]['file_code'];
$tmdb = $tempArray[$mini_id]['tmdb'];

$check = check_source($server, $file_code);

$data = array('title' => $title,'year' => $year, 'tmdb' => $tmdb, 'server' => $server,'file_code' => $file_code,'active' => $check[0],'last_check' => $check[1]);

$tempArray[$mini_id] = $data;
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

?>

<?php

include ('./functions.php');

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$id = $_POST['id'];
$title = urlencode(strtolower(trim($_POST['title'])));
$year = $_POST['year'];
$url = $_POST['url_file'];
$tmdb = $_POST['tmdb'];

$parts = parse_url($url);
$server = explode('.', str_replace('www.','',$parts['host']))[0];
$path = explode('/', str_replace('?','',$url));
$param = explode('&', $path[sizeof($path)-1]);
$check = check_source($server, $param[0]);

$data = array('title' => $title,'year' => $year, 'tmdb' => $tmdb, 'server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);

$tempArray[$id] = $data;
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./movie.php?id='.$id); 

?>

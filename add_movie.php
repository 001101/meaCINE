<?php

include ('functions.php');
$tmdb_api_key = 'fde5af48a46964a02e794bd35e081342';

$jsonfile = 'movies.json';
if (!file_exists($jsonfile)) {
    $my_file = fopen($jsonfile, "w");
	fclose($my_file);
}

$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);
if ($tempArray == "") { $tempArray = [];}

$title = urlencode(strtolower(trim($_POST['title'])));
$year = $_POST['year'];
$url = $_POST['url_file'];
$parts = parse_url($url);
$server = explode('.', str_replace('www.','',$parts['host']))[0];
$path = explode('/', str_replace('?','',$url));
$param = explode('&', $path[sizeof($path)-1]);
$check = check_source($server, $param[0]);

$data = array('title' => $title,'year' => $year, 'tmdb' => $tmdb, 'server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);

$json = json_decode(file_get_contents('http://api.themoviedb.org/3/search/movie?query='.urlencode(str_replace("'","",$_POST['title'])).'&year='.$year.'&api_key='.$tmdb_api_key), true);
$movie_id = $json['results'][0]['id'];
	
if ( count($tempArray) != 0 ) {
	$findKey1 = search_revisions($tempArray, $title,'title', $year, 'year');
	if ( count($findKey1) != 0 ) {
		include "./header.php"; 
		echo '<h1>Erreur</h1><br>';
		echo 'Ce film est déjà présent dans la base de données</br>';
		include("./footer.php");
		exit();
	}

	$findKey2 = search_revisions($tempArray, $param[0],'file_code');
	if ( count($findKey1) != 0 ) {
		include "./header.php"; 
		echo '<h1>Erreur</h1><br>';
		echo 'Cette source est déjà présente dans la base de données</br>';
		include("./footer.php");
		exit();
	}
}

$data = array('title' => $title,'year' => $year,'tmdb' => $movie_id,'server' => $server,'file_code' => $param[0]);
array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);
header('Location: ./index.php');

?>

<?php

include "./header.php";  

if(isset($_GET["n"])) { $fl = $_GET["n"]; } else { $fl = "a"; }
$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);

if ($inp != "") {
	$letters = array();
	$moviearray = json_decode($inp, true);
	foreach ($moviearray as $key => $movie) {
		$letters[] = $movie['title'][0];
	}
	echo '<h1>Films</h1><br>';
	echo '<b>Titres</b>';
	$letters = array_unique($letters);
	natsort($letters);
	foreach ($letters as $letter) {
		echo '&nbsp;|&nbsp;<a href="./titles.php?n='.$letter.'">'.ucfirst($letter).'</a>';
	}
	echo '<br><br>';
	$moviearray = array_reverse($moviearray, true);
	foreach($moviearray as $key => $movie) {
		if(preg_match("/^$fl/i", $movie['title'])) {
			$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
			echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
		}
	}
}

include("./footer.php");

?>

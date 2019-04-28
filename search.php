<?php

include "./header.php";  

if ($_POST['query'] != "") {
	$query = $_POST['query'];
	echo '<h1>Résultat de la recherche <i>'.$query.'</i></h1><br>';
	$jsonfile = 'movies.json';
	$inp = file_get_contents($jsonfile);
	if ($inp != "") {
		$moviearray = json_decode($inp, true);
		$moviearray = array_reverse($moviearray, true);
		foreach($moviearray as $key => $movie) {
			if(preg_match("/\b$query\b/i", $movie['title'])) {
				$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
				echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
			}
			if(preg_match("/\b$query\b/i", $movie['file_code'])) {
				$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
				echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
			}
		}
	}
}

include("./footer.php");

?>

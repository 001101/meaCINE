<?php

include "./header.php";  

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {
	echo '<h1>Films sans source</h1><br>';
	$moviearray = json_decode($inp, true);
	$moviearray = array_reverse($moviearray, true);
	foreach ($moviearray as $key => $movie) {
		if ( $movie['active'] == 0 ) {
			$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
			echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
		}
	}
}

include("./footer.php");

?>

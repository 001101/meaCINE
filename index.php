<?php

include "./header.php";  


echo '<h1>Ajouter un film</h1><br>';
echo '<form action="./add_movie.php" method="post"><input type="text" placeholder="titre du film..." name="title" size="50" value=""> <input type="text" placeholder="année..." name="year" value="" size="4" > <input type="text" placeholder="URL uptobox ou 1fichier..." name="url_file" value="" size="50"> <input id="submit" type="submit" name="submit" value="Ajouter"></form></br>';

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {
	$moviearray = json_decode($inp, true);
	$moviearray = array_reverse($moviearray, true);

	$broken = 0;
	foreach ($moviearray as $key => $movie) {
		if ( $movie['active'] == 0 ) {
			$broken++;
		}
	}

	if ($broken != 0) {
		echo '<h1>Films sans source</h1><br>';
		foreach ($moviearray as $key => $movie) {
			if ( $movie['active'] == 0 ) {
				$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
				echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
			}
		}
	echo '<br><br>';
	}

	$i = 0;
	echo '<h1>Les 50 derniers films</h1><br>';
	foreach ($moviearray as $key => $movie) {
		if ( $movie['active'] == 1 ) {
			$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
			echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
			if(++$i > 50) break;
		}
	}
}

include("./footer.php");

?>

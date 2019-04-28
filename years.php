<?php

include "./header.php";  

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);

if ($inp != "") {
	$years = array();
	$moviearray = json_decode($inp, true);
	foreach ($moviearray as $key => $movie) {
		$years[] = $movie['year'];
	}
	$years = array_unique($years);
	rsort($years);
	if(isset($_GET["n"])) { $fl = $_GET["n"]; } else { $fl = $years[sizeof($years)-1]; }
	echo '<h1>Films</h1><br>';
	echo '<b>Années</b>';
	foreach ($years as $year) {
		echo '&nbsp;|&nbsp;<a href="./years.php?n='.$year.'">'.$year.'</a>';
	}
	echo '<br><br>';
	$moviearray = array_reverse($moviearray, true);
	foreach($moviearray as $key => $movie) {
		if( $movie['year'] == $fl ) {
			$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
			echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
		}
	}
}

include("./footer.php");

?>

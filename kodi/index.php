<?php

$jsonfile = '../movies.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {
	$moviearray = json_decode($inp, true);
	foreach ($moviearray as $key => $movie) {
		if ( $movie['active'] == 1 ) {
			echo '<a href="'.$movie['title'].urlencode(' ('.$movie['year'].')').'.mp4">'.urldecode($movie['title']).' ('.$movie['year'].').mp4</a>'."\n";
		}
	}
}

?>

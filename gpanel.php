<?php

echo '<a href="./index.php"><img class="logo" src="logo.png"></a></br>';
echo '<form action="./search.php" method="post"><input type="text" class="menu" placeholder="rechercher..." name="query" value=""> <input id="submit" type="submit" name="submit" value="Go"></form></br>';

echo '<b>Films</b><hr>';
echo '<a href="./titles.php">par titre</a></br>';
echo '<a href="./years.php">par année</a></br>';

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {
	$moviearray = json_decode($inp, true);
	$moviearray = array_reverse($moviearray, true);
	echo '</br></br><b>Status</b><hr>';
	echo '<a>Films:</a> '.count($moviearray).'<br>';
	$uptobox = 0;
	foreach ($moviearray as $movie) { if ( $movie['server'] == 'uptobox' ) { $uptobox++; } }
	echo '<b>Sources uptobox:</b> '.$uptobox.'</br>';
	$fichier = 0;
	foreach ($moviearray as $movie) { if ( $movie['server'] == '1fichier' ) { $fichier++; } }
	echo '<b>Sources 1fichier:</b> '.$fichier.'</br>';
	$broken = 0;
	foreach ($moviearray as $movie) { if ( $movie['active'] == 0 ) { $broken++; } }
	echo '<b>Films sans source:</b> <a href="./broken.php">'.$broken.'</a></br>';
}

echo '</br></br>';
echo '<b>meaCINE</b></br>';
echo 'version 1.2.1</br>';
echo '&copy; Angelscry</br>';
?>

<?php

include "./header.php";  

date_default_timezone_set('America/Montreal');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

$jsonfile = 'movies.json';
$inp = file_get_contents($jsonfile);
$moviearray = json_decode($inp, true);

echo '<table>';
echo '<tr><td><h1>'.ucfirst(urldecode($moviearray[$_GET['id']]['title'])).'</h1></td></tr>';

$url_file = "";
if ( $moviearray[$_GET['id']]['server'] == 'uptobox' ) { $url_file = 'https://www.uptobox.com/'.$moviearray[$_GET['id']]['file_code']; }
if ( $moviearray[$_GET['id']]['server'] == '1fichier' ) { $url_file = 'https://www.1fichier.com/?'.$moviearray[$_GET['id']]['file_code']; }
	
if ( $moviearray[$_GET['id']]['tmdb'] != "" ) {
	$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$moviearray[$_GET['id']]['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
	echo '<tr><td><b>Sortie :</b> '.strftime('%e %B %Y', strtotime($json['release_date'])).'</td></tr>';
	echo '<tr><td><img class="cover" src="http://image.tmdb.org/t/p/w200'.$json['poster_path'].'">';
	echo '<img class="fanart" src="http://image.tmdb.org/t/p/w500'.$json['backdrop_path'].'"></td></tr>';
	echo '<tr><td>'.$json['overview'].'</td></tr>';
}
	echo '<tr><td><h2>Éditer</h2><hr><br>';
echo '<form action="./update_movie.php" method="post"><b>Titre</b> <input type="hidden" name="id" value="'.$_GET['id'].'"> <input type="text" name="title" size="50" value="'.urldecode($moviearray[$_GET['id']]['title']).'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Année</b> <input type="text" name="year" value="'.$moviearray[$_GET['id']]['year'].'" size="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if ( $moviearray[$_GET['id']]['tmdb'] != "" ) {
	echo '<a href="https://www.themoviedb.org/movie/'.urldecode($moviearray[$_GET['id']]['tmdb']).'" target="tmdb">TMDB</a>';
} else {
	echo '<a href="https://www.themoviedb.org/search?query='.urldecode($moviearray[$_GET['id']]['title']).'" target="tmdb">TMDB</a>';
}
echo '&nbsp;<input type="text" name="tmdb" value="'.$moviearray[$_GET['id']]['tmdb'].'" size="5" ><br>';

echo '<b>Source</b> <input type="text" name="url_file" value="'.$url_file.'" size="50">&nbsp;&nbsp;';

echo '<a href="'.$url_file.'" target="extern_'.$_GET['id'].'">';
if ( $moviearray[$_GET['id']]['active'] == 1 ) { echo '<img src="./good.png" class="icon" title="'.strftime('le %F à %T',$moviearray[$_GET['id']]['last_check']).'">'; }
if ( $moviearray[$_GET['id']]['active'] == 0 ) { 
	if ( $moviearray[$_GET['id']]['last_check'] == "" ) {
		echo '<img src="./unknow.png" class="icon">';
	} else {
		echo '<img src="./bad.png" class="icon" title="'.strftime('le %F à %T',$moviearray[$_GET['id']]['last_check']).'">';
	}
}  
echo '</a>&nbsp;&nbsp;';
echo '<input id="submit" type="submit" name="submit" value="Modifier / Vérifier"></form>';

echo '<hr><h2><a href="./delete_movie.php?id='.$_GET['id'].'" onclick="return confirm(\'Voulez-vous vraiment effacer ce film?\');">supprimer</a></h2></br></br>';
echo '</td></tr>';
echo '</table>';

include("./footer.php");

?>

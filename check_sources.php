<?php

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

// Uptobox
$result = mysql_query("SELECT * FROM `source` WHERE `url` LIKE '%uptobox%' ORDER BY `date` ASC LIMIT 0,1") or die(mysql_error());
while ( $data = mysql_fetch_array($result)) {
	$active = "";
	$content = url_get_contents($data['url']);
	echo $data['url'].' - ';
	if(strstr($content, "Unfortunately")) { 
		$active = 0;
		echo "no file</br>";
		$update_item = mysql_query("UPDATE `source` SET active='0' WHERE id='".$data['id']."'") or die(mysql_error());
	}
	if(strstr($content, "You have requested")) {
		$active = 1;
		echo "found</br>";
		$update_item = mysql_query("UPDATE `source` SET active='1' WHERE id='".$data['id']."'") or die(mysql_error());
	}
	$update_item = mysql_query("UPDATE `source` SET date=current_timestamp WHERE id='".$data['id']."'") or die(mysql_error());
}

// 1Fichier
$result = mysql_query("SELECT * FROM `source` WHERE `url` LIKE '%1fichier%' ORDER BY `date` ASC LIMIT 0,1") or die(mysql_error());
while ( $data = mysql_fetch_array($result)) {
	$active = "";
	$content = url_get_contents($data['url']);
	echo $data['url'].' - ';
	if(strstr($content, "existe pas")) { 
		$active = 0;
		echo "no file</br>";
		$update_item = mysql_query("UPDATE `source` SET active='0' WHERE id='".$data['id']."'") or die(mysql_error());
	}
	if(strstr($content, "été supprimé")) { 
		$active = 0;
		echo "no file</br>";
		$update_item = mysql_query("UPDATE `source` SET active='0' WHERE id='".$data['id']."'") or die(mysql_error());
	}
	if(strstr($content, "Nom du fichier")) {
		$active = 1;
		echo "found</br>";
		$update_item = mysql_query("UPDATE `source` SET active='1' WHERE id='".$data['id']."'") or die(mysql_error());
	}
	$update_item = mysql_query("UPDATE `source` SET date=current_timestamp WHERE id='".$data['id']."'") or die(mysql_error());
}

// Nettoyage sources cassées
$result = mysql_query("SELECT * FROM `source` WHERE `active`='0' ORDER BY `id` DESC") or die(mysql_error());
while ( $data = mysql_fetch_array($result)) {
	$result2 = mysql_query("SELECT * FROM `film` WHERE `id`='".$data['film']."'") or die(mysql_error());
	while ( $data2 = mysql_fetch_array($result2)) {
		$update_film = mysql_query("UPDATE `film` SET nb_source_active='".($data2['nb_source_active']-1)."' WHERE id='".$data2['id']."'") or die(mysql_error());
	}
	$delete_item = mysql_query("DELETE FROM `source` WHERE id='".$data['id']."'") or die(mysql_error());
}

mysql_close();

?>

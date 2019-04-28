<?php

include "../config.php";  

$filename = explode(' (', $_GET['id']);
$jsonfile = '../movies.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {
	$moviearray = json_decode($inp, true);
	foreach($moviearray as $key => $movie) {
		if( urlencode($filename[0]) == $movie['title']) {
			if ( $movie['server'] == 'uptobox' ) {
				$url = "https://uptobox.com/api/link?token=".$uptobox_api_key."&file_code=".$movie['file_code'];
				$return = file_get_contents($url);
				$obj = json_decode($return, true);
				header("Location: ".$obj['data']['dlLink']);
			}
			if ( $movie['server'] == '1fichier' ) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://api.1fichier.com/v1/download/get_token.cgi");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('url' => 'https://1fichier.com/?'.$movie['file_code'],'pretty' => '1')));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer '.$fichier_api_key]);
				$obj = json_decode(curl_exec ($ch), true);
				curl_close ($ch);
				header("Location: ".$obj['url']);
			}
		}
	}
}

?>

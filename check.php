<?php
//check if a site is up and on correct ip
echo '<meta charset="UTF-8">';
$myIp="173.212.219.84";

$domains = array(
	'dslr.gr',
	'taksidi.gr',
 );
foreach ($domains as $value) {
	if (isUP($value)) {
		$tmpIp=gethostbyname($value);
		if ($tmpIp!=$myIp) {
			echo "<p style='color:red'>".$value."</p>";
		}
	}
	else{
		echo "<br>Δεν υπάρχει το ".$value."<br>";
	}
	
}

function isUP($domain){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $domain);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10); //follow up to 10 redirections - avoids loops
	$data = curl_exec($ch);
	curl_close($ch);
	if (!$data) {
	  //echo "<br>Error 404 ".$domain."<br>";
	  return false;
	}
	else {
	  preg_match_all("/HTTP\/1\.[1|0]\s(\d{3})/",$data,$matches);
	  $code = end($matches[1]);
	  if ($code == 200) {
	    return true;
	  }
	  elseif ($code == 404) {
	    return false;
	  }
	}
}

?>


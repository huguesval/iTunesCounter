<?php
require_once('fonctions.php');
session(true);


$file = 'uploads/'.$_SESSION['uid'].'.xml';


/**
* Initialisation des sessions
*/
if(isset($_GET['reset']))
	$_SESSION['it'] = 0;
if($_SESSION['it'] == 0){
	$_SESSION['count'] = 0;
	$_SESSION['ftell'] = 0;
	$_SESSION['filesize'] = filesize($file);
	$_SESSION['oldcount'] = 0;
	$_SESSION['tps'] = 0;
	$_SESSION['tpstot'] = 0;
	$_SESSION['genre'] = array(array());
	$_SESSION['more'] = true;
	$_SESSION['maxCount'] = 0;
	$_SESSION['podcast'] = 0;
}
$_SESSION['oldcount'] = $_SESSION['count'];

// Let's just get the number of a string in the file
// by dividing it in parts
$fp = fopen($file,'r');
fseek($fp,$_SESSION['ftell']);

$x = 0;
$tps = 0;
$count = 0;
while($x < ($_SESSION['filesize']/500)){
	$foo = fgets($fp,4096);

	// Debug
	//echo $foo.'<br />';
	
	// si on change de chanson, on enregistre les informations sur l'ancienne :
	if(strpos($foo,'</dict>') !== false){
		$_SESSION['tps'] += $tps/1000;
		$_SESSION['tpstot'] += $tps*$count/1000;
		// et puis on check si c'est pas la plus écoutée
	}
	// temps que l'on est pas dans les playlists :
	if(strpos($foo,'<key>Playlists</key>') !== false){
		$tps = 0;
		$count = 0;
		$_SESSION['more'] = false;
	}
	// Time
	if(strpos($foo,'<key>Total Time</key><integer>') !== false){
		$foo = substr($foo,strpos($foo,'<key>Total Time</key><integer>')+30,strlen($foo));
		$end = strpos($foo,"</integer>");
		$tps = substr($foo,0,$end);
	}
	// Genre
	if(strpos($foo,'<key>Genre</key><string>') !== false){
		$foo = substr($foo,strpos($foo,'<key>Genre</key><string>')+24,strlen($foo));
		$end = strpos($foo,"</string>");
		$_SESSION['genre'][substr($foo,0,$end)]++;
	}
	// Podcast
	if(strpos($foo,'Podcast</key><true/>') !== false){
			$_SESSION['podcast']++;
	}
	// Name
	if(strpos($foo,'<key>Name</key><string>') !== false){
		$foo = substr($foo,strpos($foo,'<key>Name</key><string>')+23,strlen($foo));
		$end = strpos($foo,"</string>");
		// Keep old music
		$_SESSION['TrackNameNew'] = substr($foo,0,$end);
	}
	// Count
	if(strpos($foo,'<key>Play Count</key><integer>') !== false){
		$foo = substr($foo,strpos($foo,'<key>Play Count</key><integer>')+30,strlen($foo));
		$end = strpos($foo,"</integer>");
		$count = substr($foo,0,$end);
		if($count > $_SESSION['maxCount']){
			$_SESSION['maxCount'] = $count;
			$_SESSION['TrackName'] = $_SESSION['TrackNameNew'];
		}
	}
	
	// Can we stop reloading ?
	if(strpos($foo,'<key>Track ID</key><integer>') !== false)
		$_SESSION['count']++;
	// Are we still in music (not in playlist) ?
	if(strpos($foo,'<key>Track ID</key><integer>') !== false && $_SESSION['more'] === true)
		$_SESSION['music']++;
	
	
	
	$x++;
}


// where the fuck am I ?
$_SESSION['ftell'] = ftell($fp);


$_SESSION['it']++;
sleep(2);


if($_SESSION['oldcount'] != $_SESSION['count'])
	header('Location:up.php');

fclose($fp);
?>
<?php
function connect(){

	/* Permet de génerer le temps de chargement de la page : 
	global $getmtdeb;
	$getmtdeb = getmicrotime();
	//*/

	if(!$db = @mysql_connect('localhost','root','root'))
		header('Location:index.php');
	if(!@mysql_select_db('itunes', $db))
		header('Location:index.php');
	
	
}


function deconnect(){
	mysql_close();
}
// Calcul du temps de chargement des pages
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

function session($type){
	if($type != 0 && $type != 1){
		//error('Erreur dans les sessions');
		return 'Une erreur est survenue. Veuillez essayer de vous reconnecter';
	}
	if($type === true){
		session_start();
	}
	else if ($type === false){
		session_destroy();
	}
}


function error($error,$user = 'Visitor'){
	if(!session_is_registered('pseudo'))
		mysql_query('INSERT INTO error_reporting VALUES("","'.$user.'","'.time().'","'.$error.'")');
	else
		mysql_query('INSERT INTO error_reporting VALUES("","'.$_SESSION['pseudo'].'","'.time().'","'.$error.'")');
	return $error;
}

function query($query){
	$q = mysql_query($query) or die(error('Erreur QUERY de requête : '.$query.' à la ligne '.mysql_errno().' '.mysql_error()));
	return $q; 
}

function num_rows($query){
	$q = mysql_num_rows($query) or die(error('Erreur NUM_ROWS de requête : '.$query.' à la ligne '.mysql_errno().' '.mysql_error()));
	return $q;
}

function verifbdd($var){
	$var = mysql_escape_string(str_replace("\r\n","<br />",htmlspecialchars(stripslashes($var))));
	return $var;
}
function table_exist($tableName){
	$req = mysql_query('SELECT COUNT(*) FROM '.$tableName);
	$nb = @mysql_num_rows($req);
	if($nb) return true;
	else return false;
}
/**
* Function ssAccents : Prends un tring en entrée et retourne ce string sans les accents
* @var $string : Chaine de caractères
*/
function ssAccents($string){
	$s = strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	return $s;
}
/**
* fonction s : Utile pour le pluriel. Retourne 's' si l'entrée est supérieure à 1
* @var $i : Nombre d'entrée
*/
function s($i){
	if($i > 1 && is_numeric($i)) return 's';
}

function timeMicroToDays($time){
	$res = array();
	$time /= 3600;
	if($time > 24)
		$res['j'] = floor($time/24);
	$time -= $res['j'] * 24;
	if($time > 1)
		$res['h'] = floor($time);
	$time -= $res['h'];
	if($time > 0)
		$res['m'] = floor($time*60);
	$res['s'] = floor($time*3600 - $res['m']*60);
	$r = $res['j'].' j '.$res['h'].' h '.$res['m'].' m '.$res['s'].' s';
	return $r;
}
<?php
require_once("fonctions.php");
connect();

if(isset($_GET['mail'])){
	if(isset($_POST['mail'])){
		$mail = verifbdd($_POST['mail']);
		$req = query('SELECT mail,pseudo FROM itunescounter WHERE mail LIKE "'.$mail.'"');
		$c = mysql_num_rows($req);
		
		if($c == 0)
			echo '0';
		else
			echo mysql_result($req,0,'pseudo');
	}
}

if(isset($_GET['pseudo'])){
if(isset($_POST['pseudo'])){
	$pseudo = verifbdd($_POST['pseudo']);
	$req = query('SELECT pseudo FROM itunescounter WHERE pseudo LIKE "'.$pseudo.'"');
	$c = mysql_num_rows($req);
	
	
	if(!preg_match('/^[A-Za-z0-9_\-]+$/', $pseudo) || $c != 0){
		if(!preg_match('/^[A-Za-z0-9_\-]+$/', $pseudo))
			$echo = '<div style="color:#BBBBBB;font-size:13px;">N\'utiliser que des lettres et des chiffres</div>';
		if($c != 0)
			$echo = '<div style="color:#BBBBBB;font-size:13px;">'.$pseudo.' n\'est pas disponible !</div>';
	}
	else{
		$echo = '<div style="color:#333333;font-size:13px;">'.$pseudo.' est disponible.</div>';
	}
}

$replace = array('é', 'ê', 'è', 'É', 'È', 'Ê', 'à', 'À', 'ï', 'î', 'Ï', 'Î', 'ô', 'Ô', 'ù','ç');
$by = array('&eacute;', '&ecirc;', '&egrave;', '&Eacute;', '&Egrave;', '&Ecirc;', '&agrave;', '&Agrave;', '&iuml;', '&icirc;', '&Iuml;', '&Icirc;','&ocirc;', '&Ocirc;', '&ugrave;', '&ccedil;');
$echo = str_replace($replace,$by,$echo);
echo $echo;
}


deconnect();
?>
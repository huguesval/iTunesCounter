<?php
require_once('fonctions.php');
connect();
session(true);
if(!isset($_GET['c']) || $_GET['c'] != 'podcast' || $_GET['c'] != 'countmostlistened' || $_GET['c'] != 'countgenre' || $_GET['c'] != 'pseudo' || $_GET['c'] != 'music' || $_GET['c'] != 'tps' || $_GET['c'] != 'tpstot')
	$_GET['c'] = 'date';

if((isset($_POST['pseudo']) || isset($_POST['formpseudo'])) && isset($_POST['mail']) && !isset($_GET['free'])){
	if(isset($_POST['pseudo']) && preg_match('/^[A-Za-z0-9_\-]{3,15}$/', $_POST['pseudo'])){
		$pseudo = ssAccents(verifbdd($_POST['pseudo']));
	}
	else if(isset($_POST['formpseudo']) && preg_match('/^[A-Za-z0-9_\-]{3,15}$/', $_POST['formpseudo'])){
		$pseudo = ssAccents(verifbdd($_POST['formpseudo']));
	}
	else
		$error .= 'Votre pseudo n\'est pas bon. Veuillez retourner à <a href="res.php">la page précédente</a>';
	$_SESSION['pseudo'] = $pseudo;
	if(preg_match('/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/', $_POST['mail'])){
		$mail = verifbdd($_POST['mail']);
	}
	else 
		$error .= 'Votre adresse mail n\'a pas le bon format';
	
	$req = query('SELECT mail, pseudo FROM itunescounter WHERE mail LIKE "'.$mail.'"');
	$c = mysql_num_rows($req);
	
	if($c != 0){
		// Check that pseudo is good
		if(mysql_result($req,0,"pseudo") != $pseudo)
			$error .= 'Votre pseudo n\'est pas bon. Veuillez retourner à <a href="res.php">la page précédente</a>';
	}
	if($error == '')	// On enregistre quand même
		query('INSERT INTO itunescounter VALUES ("","'.time().'","'.$mail.'","'.$pseudo.'","'.$_SESSION['tps'].'","'.$_SESSION['tpstot'].'","'.$_SESSION['music'].'","'.$_SESSION['genreMaxString'].'","'.$_SESSION['genreMaxValue'].'","'.$_SESSION['TrackName'].'","'.$_SESSION['maxCount'].'","'.$_SESSION['podcast'].'")');
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Voir tous les résultats | iTunesCounter</title>
<meta name="description" content="iTunes Counter permet de calculer le temps que vous avez écoutez votre bibliothèque iTunes. Savoir combien de temps vous avez écoutez votre musique au total, savoir le genre de musique que vous écoutez le plus et bien d'autres choses !"/>
<meta name="keywords" content="iTunes, itune, calculer, calculez, calcul, bibliothèque, bibliotheque, écoute, ecoute, écouter, ecouter, temps, " />
<meta name="author" content="Hugues Valentin" />
<link rel="stylesheet" media="screen" type="text/css" href="design.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/fonctions.js"></script>
<style type="text/css">
.right{border-right:2px solid #333333;border-bottom:2px solid #BBBBBB;padding-right:10px;text-align:right;}
.left{padding-left:10px;text-align:left;border-bottom:2px solid #BBBBBB;font-size:20px;}
td{border-bottom:2px solid #BBBBBB;border-right:2px solid #BBBBBB}
th{border-bottom:2px solid #333333;}
table{border-collapse:collapse;}
</style>
</head>
<body>
<div id="wrappertop"></div>
	<div id="wrappermiddle">
		<div id="wrappermiddle-in">
		<br />
		<?php
		if(!isset($_GET['mine']))
			echo '<h2>Toutes les bibliothèques</h2><a href="results.php?mine">Suivre l\'évolution de sa bibliothèque</a><br /><br />';
		else
			echo '<h2>Ma bibliothèque</h2><a href="results.php?free">Voir toutes les bibliothèques</a><br /><br />';
		?>
		<?php echo $error; ?>
		<?php if(!isset($_GET['mine'])){?>
		<table align="center">
			<tr><th><a href="results.php?free&c=date">date</a></th><th><a href="results.php?free&c=pseudo">pseudo</a></th><th><a href="results.php?free&c=music">musiques</a></th><th><a href="results.php?free&c=tps">Durée</a></th><th><a href="results.php?free&c=tpstot">Temps d'écoute</a></th><th><a href="results.php?free&c=countgenre">Genre</a></th><th><a href="results.php?free&c=countmostlistened">Musique + écoutée</a></th><th><a href="results.php?free&c=podcast">podcast</a></th></tr>
			<?php
			$req = query('SELECT * FROM itunescounter ORDER BY '.verifbdd($_GET['c']).' DESC');
			$c = mysql_num_rows($req);
			$pseudos = array();
			for($i=0;$i<$c;$i++){
				if(!in_array(mysql_result($req,$i,'pseudo'), $pseudos)){
					$pseudos[] = mysql_result($req,$i,'pseudo');
					if(mysql_result($req,$i,'pseudo') == $_SESSION['pseudo']){
						echo '<tr style="font-weight:bold">
							<td>'.date("d/m/Y",mysql_result($req,$i,'date')).'</td>
							<td>'.mysql_result($req,$i,'pseudo').'</td>
							<td>'.mysql_result($req,$i,'music').'</td>
							<td>'.timeMicroToDays(mysql_result($req,$i,'tps')).'</td>
							<td>'.timeMicroToDays(mysql_result($req,$i,'tpstot')).'</td>
							<td>'.mysql_result($req,$i,'genre').' ('.mysql_result($req,$i,'countgenre').')</td>
							<!--<td>'.mysql_result($req,$i,'countgenre').'</td>-->
							<td>'.mysql_result($req,$i,'mostlistened').' ('.mysql_result($req,$i,'countmostlistened').')</td>
							<td>'.mysql_result($req,$i,'podcast').'</td>
						</tr>';
					}
					else{
						echo '<tr>
							<td>'.date("d/m/Y",mysql_result($req,$i,'date')).'</td>
							<td>'.mysql_result($req,$i,'pseudo').'</td>
							<td>'.mysql_result($req,$i,'music').'</td>
							<td>'.timeMicroToDays(mysql_result($req,$i,'tps')).'</td>
							<td>'.timeMicroToDays(mysql_result($req,$i,'tpstot')).'</td>
							<td>'.mysql_result($req,$i,'genre').' ('.mysql_result($req,$i,'countgenre').')</td>
							<!--<td>'.mysql_result($req,$i,'countgenre').'</td>-->
							<td>'.mysql_result($req,$i,'mostlistened').' ('.mysql_result($req,$i,'countmostlistened').')</td>
							<td>'.mysql_result($req,$i,'podcast').'</td>
						</tr>';
					}
				}
			}
			?>
			
			
		</table>
		<?php }// !isset($_GET['mine'])
		else{
		?>
			<table align="center">
			<tr><th><a href="results.php?mine&c=date">date</a></th><!--<th><a href="results.php?mine&c=pseudo">pseudo</a></th>--><th><a href="results.php?mine&c=music">musiques</a></th><th><a href="results.php?mine&c=tps">Durée</a></th><th><a href="results.php?mine&c=tpstot">Temps d'écoute</a></th><th><a href="results.php?mine&c=countgenre">Genre</a></th><th><a href="results.php?mine&c=countmostlistened">Musique + écoutée</a></th><th><a href="results.php?mine&c=podcast">podcast</a></th></tr>
		<?php
		$req = query('SELECT * FROM itunescounter WHERE pseudo LIKE "'.$_SESSION['pseudo'].'" ORDER BY '.verifbdd($_GET['c']).' DESC');
			$c = mysql_num_rows($req);
			for($i=0;$i<$c;$i++){
				echo '<tr>
					<td>'.date("d/m/Y",mysql_result($req,$i,'date')).'</td>
					<!--<td>'.mysql_result($req,$i,'pseudo').'</td>-->
					<td>'.mysql_result($req,$i,'music').'</td>
					<td>'.timeMicroToDays(mysql_result($req,$i,'tps')).'</td>
					<td>'.timeMicroToDays(mysql_result($req,$i,'tpstot')).'</td>
					<td>'.mysql_result($req,$i,'genre').' ('.mysql_result($req,$i,'countgenre').')</td>
					<!--<td>'.mysql_result($req,$i,'countgenre').'</td>-->
					<td>'.mysql_result($req,$i,'mostlistened').' ('.mysql_result($req,$i,'countmostlistened').')</td>
					<td>'.mysql_result($req,$i,'podcast').'</td>
				</tr>';
			}
			echo '</table>';
		}
		?>
		
		</div>
	</div>
	<div id="wrapperbottom"></div>
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	var pageTracker = _gat._getTracker("UA-3626555-3");
	pageTracker._initData();
	pageTracker._trackPageview();
	</script>ript>
</body>
</html>
<?php deconnect();?>
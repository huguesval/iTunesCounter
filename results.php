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
		$error .= 'Your username isn\'t good. Please go <a href="res.php">back</a>';
	$_SESSION['pseudo'] = $pseudo;
	if(preg_match('/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/', $_POST['mail'])){
		$mail = verifbdd($_POST['mail']);
	}
	else 
		$error .= 'Your email address is not at the right format';
	
	$req = query('SELECT mail, pseudo FROM itunescounter WHERE mail LIKE "'.$mail.'"');
	$c = mysql_num_rows($req);
	
	if($c != 0){
		// Check that pseudo is good
		if(mysql_result($req,0,"pseudo") != $pseudo)
			$error .= 'Your username is not good. Please come <a href="res.php">back</a>';
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
<meta name="description" content=""/>
<meta name="keywords" content="" />
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
			echo '<h2>All Libraries</h2><a href="results.php?mine">Only see my results</a><br /><br />';
		else
			echo '<h2>My Library</h2><a href="results.php?free">see all libraries</a><br /><br />';
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
			<tr><th><a href="results.php?mine&c=date">date</a></th><!--<th><a href="results.php?mine&c=pseudo">pseudo</a></th>--><th><a href="results.php?mine&c=music">musics</a></th><th><a href="results.php?mine&c=tps">time</a></th><th><a href="results.php?mine&c=tpstot">total time</a></th><th><a href="results.php?mine&c=countgenre">Genre</a></th><th><a href="results.php?mine&c=countmostlistened">Most listened track</a></th><th><a href="results.php?mine&c=podcast">podcast</a></th></tr>
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
</body>
</html>
<?php deconnect(); ?>
<?php
require_once('fonctions.php');
session(true);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Afficher vos résultats | iTunesCounter</title>
<meta name="description" content="iTunes Counter permet de calculer le temps que vous avez écoutez votre bibliothèque iTunes. Affichage de vos résultats."/>
<meta name="keywords" content="iTunes, itune, calculer, calculez, calcul, bibliothèque, bibliotheque, écoute, ecoute, écouter, ecouter, temps, ,afficher, résultat" />
<meta name="author" content="Hugues Valentin" />
<link rel="stylesheet" media="screen" type="text/css" href="design.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/fonctions.js"></script>
<style type="text/css">
.right{border-right:2px solid #333333;border-bottom:2px solid #BBBBBB;padding-right:10px;text-align:right;}
.left{padding-left:10px;text-align:left;border-bottom:2px solid #BBBBBB;font-size:20px;}
table{border-collapse:collapse;}
</style>
</head>
<body>
<div id="wrappertop"></div>
	<div id="wrappermiddle">
		<div id="wrappermiddle-in">
				<br />
				<h2>Résultats</h2>
				<?php
					// Avoid infinite array
					$_SESSION['genre'][0] = -1;
					$genre = array();
					$genre = $_SESSION['genre'];
					$old = 0;
					for($i=0;$i<count($_SESSION['genre']);$i++){
						$cur = current($genre);
						if($cur > $old){
							$_SESSION['genreMaxString'] = key($genre);
							$_SESSION['genreMaxValue'] = $cur;
							$old = $cur;
						}
						next($genre);
					}
				?>
			<table width="600px" align="center">
				<tr><th width="50%">&nbsp;</th><th width="50%">&nbsp;</th></tr>
				<tr><td class="right">Nombre de musique</td><td class="left"><?php echo $_SESSION['music'];?></td></tr>
				<tr><td class="right">Nombre de podcast</td><td class="left"><?php echo $_SESSION['podcast'];?></td></tr>
				<tr><td class="right">Durée de la bibliothèque </td><td class="left"><?php echo timeMicroToDays($_SESSION['tps']); ?></td></tr>
				<tr><td class="right">Temps d'écoute</td><td class="left"><?php echo timeMicroToDays($_SESSION['tpstot']);?></td></tr>
				<tr><td class="right">Genre préféré</td><td class="left"><?php echo $_SESSION['genreMaxString'].' ('.$_SESSION['genreMaxValue'].' musiques)';?></td></tr>
				<tr><td class="right">Musique la plus écoutée</td><td class="left"><?php echo $_SESSION['TrackName'].' ('.$_SESSION['maxCount'].' écoutes)';?></td></tr>
			</table>
			<br />
			Vous pouvez enregistrer votre résultat pour vous comparer aux autres !<br />
			Entrez votre adresse mail :<br />
			<div id="aff"></div>
			<form name="sub" action="results.php" method="post">
			<input type="text" name="mail" value="" id="mail" /><br /><span style="color:#FFFFFF;font-size:11px;">Il ne sera pas affiché aux autres</span>
			<div id="ok">
				Vous avez déjà envoyé votre bibliothèque sous le pseudo<br /><strong><span id="pseudodeja"></span></strong><br />Cliquer sur suivant :<br />
				<input type="submit" class="bsuivant" value=" " />
				<input type="hidden" value="" name="formpseudo" id="formpseudo" />
			</div>
			<div id="new">
				C'est la première fois que vous proposez votre bibliothèque, veuillez entrer un nom d'utilisateur :<br />
				<input type="text" name="pseudo" value="" id="pseudo" />
				<div id="explication_pseudo"></div>
				<div id="bsuivanthidden" style="display:none;">
					<input type="submit" class="bsuivant" value=" " />
				</div>
			</div>
			<div id="wrongmail">
				L'adresse mail entrée n'est pas correcte, veuillez la modifier<br />
			</div>
			</form><br /><br />
			<a href="results.php?free">Ne pas enregistrer mes résultats</a>
		</div>
	</div>
	<div id="wrapperbottom"></div>
	<script type="text/javascript">
				checkMail();
				checkPseudo();
			</script>
			<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			var pageTracker = _gat._getTracker("UA-3626555-3");
			pageTracker._initData();
			pageTracker._trackPageview();
			</script>
</body>
</html>
<?php
require_once('fonctions.php');
session(true);
$_SESSION['uid'] = uniqid();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Calculez votre temps d'écoute sur iTunes | iTunesCounter</title>
<meta name="google-site-verification" content="-A_o1nNp-w8lt7GiA9czbz_fAhdN1oc-x7bbrZJ_rw4" />
<meta name="description" content="iTunes Counter permet de calculer le temps que vous avez écoutez votre bibliothèque iTunes. Savoir combien de temps vous avez écoutez votre musique au total, savoir le genre de musique que vous écoutez le plus et bien d'autres choses !"/>
<meta name="keywords" content="iTunes, itune, calculer, calculez, calcul, bibliothèque, bibliotheque, écoute, ecoute, écouter, ecouter, temps, " />
<meta name="author" content="Hugues Valentin" />
<link rel="stylesheet" media="screen" type="text/css" href="design.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.progressbar.min.js"></script>
<script type="text/javascript" src="up/vendor/swfupload/swfupload.js"></script>
<script type="text/javascript" src="up/src/jquery.swfupload.js"></script>
<script type="text/javascript" src="js/fonctions.js"></script>


</head>
<body>
<div id="wrappertop"></div>
	<div id="wrappermiddle">
		<div id="wrappermiddle-in">
		Bienvenue sur iTunes Counter, le site internet qui permet de calculer le temps d'écoute totale sur iTunes.<br />
		Mais iTunes Counter ne permet pas que cela ! Il vous donnera aussi :
		<ul>
			<li>Le temps total de votre bibliothèque</li>
			<li>Le genre de musique que vous préférez</li>
			<li>La musique que vous écoutez le plus</li>
			<li>...</li>
		</ul>
		Pour voir toutes ces informations, il vous suffit de cliquer sur Uploader.<br />Sélectionner le fichier iTunes Music Library.xml qui se trouve :<br />
		Sur un Mac dans ~/Music/iTunes<br />
		Sur un PC dans Mes Documents\iTunes<br />
		<div id="bbb"><input type="button" id="button" /></div>
		<div id="uploadprogressbar"></div>
		<div id="progressbar"></div>
		<div id="suivant"><br />
			L'envoi s'est bien déroulé. Cliquer sur Suivant pour lancer les calculs :
			<a href="run.php"><span class="suivant">&nbsp;</span></a>
		</div>
		<div id="error"><br />
			Oups ! Une erreur s'est produite pendant le chargement. <a href="index.php">Cliquer ici</a> pour recharger la page.
		</div>
		</div>
	</div>
	<div id="wrapperbottom"></div>
	<script type="text/javascript">
				upload('<?php echo $_SESSION['uid']?>');
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
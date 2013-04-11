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
<meta name="description" content=""/>
<meta name="keywords" content="" />
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
		Welcome to iTunes Counter, a web site that allows you to calculate your total listen time on iTunes
		<br />
		You will also retrieve :
		<ul>
			<li>Your library total time</li>
			<li>Genre that you listen the most</li>
			<li>Music that you listen the most</li>
			<li>...</li>
		</ul>
		To begin, just select your iTunes Music Library.xml that can be found:<br />
		In ~/Music/iTunes on a Mac<br />
		My Documents\iTunes on a PC<br />
		<div id="bbb"><input type="button" id="button" /></div>
		<div id="uploadprogressbar"></div>
		<div id="progressbar"></div>
		<div id="suivant"><br />
			The upload went well. Click on Next to compute the results:
			<a href="run.php"><span class="suivant">&nbsp;</span></a>
		</div>
		<div id="error"><br />
			Oops! Something went wrong during the download. Please click <a href="index.php">here</a> to reload the page.
		</div>
		</div>
	</div>
	<div id="wrapperbottom"></div>
	<script type="text/javascript">
				upload('<?php echo $_SESSION['uid']?>');
			</script>
			
</body>
</html>
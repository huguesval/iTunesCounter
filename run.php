<?php
require_once('fonctions.php');
session(true);
session(false);
session(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Please wait while the server computes | iTunesCounter</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="Hugues Valentin" />
<link rel="stylesheet" media="screen" type="text/css" href="design.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.progressbar.min.js"></script>
<script type="text/javascript" src="js/fonctions.js"></script>

</head>
<body>
	<div id="wrappertop"></div>
	<div id="wrappermiddle">
		<div id="wrappermiddle-in">
			Please wait while the server computes<br />
			<div id="progressbar2"></div>
			<div id="return">
				Great !<br />
				Everything went well<br />
				Click on next<br />
				<a href="res.php">
					<span class="suivant">&nbsp;</span>
				</a>
			</div>
			<script type="text/javascript">
				doIt();
				repeatChecking();
			</script>
		</div>
	</div>
	<div id="wrapperbottom"></div>
</body>
</html>
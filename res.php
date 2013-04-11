<?php
require_once('fonctions.php');
session(true);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Show Result | iTunesCounter</title>
<meta name="description" content=""/>
<meta name="keywords" content="" />
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
				<h2>Results</h2>
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
				<tr><td class="right">Musics</td><td class="left"><?php echo $_SESSION['music'];?></td></tr>
				<tr><td class="right">Podcasts</td><td class="left"><?php echo $_SESSION['podcast'];?></td></tr>
				<tr><td class="right">Total library time</td><td class="left"><?php echo timeMicroToDays($_SESSION['tps']); ?></td></tr>
				<tr><td class="right">Total listen time</td><td class="left"><?php echo timeMicroToDays($_SESSION['tpstot']);?></td></tr>
				<tr><td class="right">Prefered genre</td><td class="left"><?php echo $_SESSION['genreMaxString'].' ('.$_SESSION['genreMaxValue'].' musiques)';?></td></tr>
				<tr><td class="right">Prefered music</td><td class="left"><?php echo $_SESSION['TrackName'].' ('.$_SESSION['maxCount'].' écoutes)';?></td></tr>
			</table>
			<br />
			You can save your results and compare to the others !<br />
			Please enter your email address:<br />
			<div id="aff"></div>
			<form name="sub" action="results.php" method="post">
			<input type="text" name="mail" value="" id="mail" /><br /><span style="color:#FFFFFF;font-size:11px;">It won't be shown to others</span>
			<div id="ok">
				You already uploaded some results with the username:<br /><strong><span id="pseudodeja"></span></strong><br />Click on next:<br />
				<input type="submit" class="bsuivant" value=" " />
				<input type="hidden" value="" name="formpseudo" id="formpseudo" />
			</div>
			<div id="new">
				It's the first time, please enter a username<br />
				<input type="text" name="pseudo" value="" id="pseudo" />
				<div id="explication_pseudo"></div>
				<div id="bsuivanthidden" style="display:none;">
					<input type="submit" class="bsuivant" value=" " />
				</div>
			</div>
			<div id="wrongmail">
				The mail address is wrong, please correct<br />
			</div>
			</form><br /><br />
			<a href="results.php?free">Don't save my results</a>
		</div>
	</div>
	<div id="wrapperbottom"></div>
	<script type="text/javascript">
				checkMail();
				checkPseudo();
			</script>
</body>
</html>
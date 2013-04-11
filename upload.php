
<?php
require_once('fonctions.php');
session(true);

// Removes files in the upload directory that are over 3 hours old, except for index.php
// You probably don't need it, but it might be nice for some people.  Uncomment if you need it.

if ($handle = opendir('uploads')) {
  while (false !== ($file = readdir($handle))) {
    if (filemtime('uploads/'.$file) < time() - 1000 && !is_dir('uploads/'.$file) && $file != 'index.php') {  
       @unlink('uploads/'.$file);
    }
  }
}


if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
		;
		move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$_POST['uid'].'.xml');
	echo '1';
}
else
	echo '0';
?>
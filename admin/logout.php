<?php
	session_start();
	header('Location: index.php?logout=not');
	session_destroy();	
?>
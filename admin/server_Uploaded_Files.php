<?php
session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

include('repair_SQL_DATEONLY.php');

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!--link href="style.css" rel="stylesheet" type="text/css"/-->
    
    <link href="css/01.PageLayout.css"          rel="stylesheet" type="text/css"/>     
    <link href="css/02.Menu.css"                rel="stylesheet" type="text/css"/> 
    <link href="css/03.Standard.css"            rel="stylesheet" type="text/css"/> 
    <link href="css/04.Tables.css"              rel="stylesheet" type="text/css"/>      
    <link href="css/05.Input.css"               rel="stylesheet" type="text/css"/>  
    <link href="css/06.RoundedBoxes.css"        rel="stylesheet" type="text/css"/>                 
    <link href="css/07.DropShadowEffect.css"    rel="stylesheet" type="text/css"/> 
    <link href="css/08.RollOverPicture.css"     rel="stylesheet" type="text/css"/> 
    <link href="css/09.Topical.css"             rel="stylesheet" type="text/css"/> 
    
	<title><?php  include("title.php");?></title>
</head>

<body>


<div id="frame">

	<div id="header">
		<?php
			include("header.php");		
		?>
	</div>
	
	<div id="columnLeft">
			<div id="navsite">		  
				<?php
					 include("Menu_Admin.php");	
				?>
			</div>
	</div>


	<div id="columnRight">
			<h1>Εμφάνιση αρχείων του διακομιστή.</h1>

	<?php
		$current_dir = '../download/';
		$dir = opendir($current_dir);
		
		echo "<p><b>Το αρχείο που αποθηκεύονται οι εικόνες είναι το :</b> $current_dir</p>";
		
		$is=0;  
		echo '<p><b>Περιέχονται τα αρχεία :</b></p><ul>';
		while ($file = readdir($dir))
		{
	?>		
		<table border align="center">			
			<tr class="<?php echo $is%2 ? 'nohilite' : 'hilite'; ?>" ><th width="50"><?php echo $is ?></th><td width="400"><a href="yahoo.gr"><?php echo $file ?></a></td></tr>			
		</table>		
	<?php
			$is++;
		}
		
		closedir($dir);
		
	?>	
	</div>
	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
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
			include("header.php");		// Εδώ δημιουργούνται τα sessions.
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
			<h1>Εμφάνιση όλων των προϊόντων</h1>			
			
			<?php
			
			//$db = new mysqli('localhost','OTEADMIN','123456','oteshop');
			include ('db_main.php');
			$sql='SELECT * FROM products ORDER BY id DESC ';  // Από το μικρότερο μεγαλύτερο νούμερο προς το μικρότερο.
			$result = $db->query($sql);
			
			$numrows = $result->num_rows;
			
			echo "<b>Συνολικός αριθμός προϊόντων  : </b>".$numrows."<br><br>";  			
			
			while ($row = $result->fetch_assoc()) {	 			
			
			$basename=basename($row['picture']);
			
			?>
			<table border>				                                                                                                   
				<tr> <td><b>id: </b></td><td width="30"><?php echo $row['id']?></td>
					 <td width="300"><?php echo $basename ?></td>							
				     <td><a href="Show_product.php?num=<?php echo $row['id'];?>" >περισσότερα.. <?php echo $row['id'] ?> </a></td>    </tr>			
			</table>		
			
			
			
			
			<?php
				echo "<br/>";
			}
				$db->close();			
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
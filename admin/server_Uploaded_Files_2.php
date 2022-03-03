<?php
	session_start();
		
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	
	include('repair_SQL_DATEONLY.php');
?>

<?php

	// **************************************************************************************************
	//                                              PHP_SELF - start
	// **************************************************************************************************
	
	if($_POST){	
		//print_r($_POST);
				
		echo "Πάτησες το ".$_POST['abc'];
		
		
		$clara=".../download/".$_POST['abc'];
		
		//----------------------------------------------------------------------
		//                      Εμφάνιση όλων των προϊόντων
		//----------------------------------------------------------------------
		
			//$db = new mysqli('localhost','OTEADMIN','123456','oteshop');
			$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
			
			$sql='SELECT * FROM books WHERE picture = '.$clara;  // Από το μικρότερο μεγαλύτερο νούμερο προς το μικρότερο.
			
			$result = $db->query($sql);
			
			$numrows = $result->num_rows;
			
			echo "<b>Συνολικός αριθμός προϊόντων  : </b>".$numrows."<br><br>";  			
			/*
			while ($row = $result->fetch_assoc()) {	 
			?>
			
			<table border>				                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" ><td rowspan=10><?php echo "<img src='" . $row['picture'] . "'  height=100 width=150 >" ?></td></tr>
								
				<tr>  <td><b>isbn: </b></td>                 <td><?php echo $row['isbn']?>                                       </td>
					  <td><a href="Products_show_one.php?isbn=<?php echo $row['isbn'];?>" >περισσότερα <?php echo $row['isbn'] ?> </a></td>    </tr>					  
				
				<tr>  <td><b>Εκδότης: </b>            </td><td><?php echo $row['author']?>                      </td></tr>
				<tr>  <td><b>Τίτλος: </b>             </td><td><?php echo $row['title']?>                       </td></tr>
				<tr>  <td><b>Κατηγορία:</b>            </td><td>
													  <?php 
													  	$db_2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
														$sql_2 = "SELECT * FROM categories WHERE catid = ".$row['catid'];
														$result_2 = $db->query($sql_2);
														//$row = $result->fetch_assoc();			
														$numrows_2 = $result_2->num_rows;
														
														$counter=0;
														while ($row_2 = $result_2->fetch_assoc() ) {
															echo $row_2['catname'];															
														} 
													  ?>
				                                       </td></tr>
				<tr>  <td><b>Τιμή: </b>               </td><td><?php echo $row['price']?>                       </td></tr>
				<tr>  <td><b>Περιγραφή: </b>          </td><td><?php echo $row['description']?>                 </td></tr>
				<tr>  <td><b>Ημερομηνία: </b>         </td><td><?php echo repair_SQL_DATEONLY($row['date'])?>   </td></tr>				
			</table>		
			
			<?php
				echo "<br/>";
			}
				$db->close();			
			
		*/
	}//<--end of if($_POST)
		
	// **************************************************************************************************
	//                                              PHP_SELF - end
	// **************************************************************************************************
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
			<h1>Εμφάνιση αρχείων του διακομιστή 2</h1>

			<form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
				
				<select name="abc" id="abc">
				  <option value="">Select an image</option>
					  <?php
						include('buildFileList5.php');
						buildFileList5('.../download/');
					  ?>
				</select>
				
				<input type="submit" id="forCSSb" value="Εμφάνιση">
			</form>
			
			<?php
			if (isset($a)){
				//echo $a;
				echo "<br>";
				//echo $clara;
			}
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
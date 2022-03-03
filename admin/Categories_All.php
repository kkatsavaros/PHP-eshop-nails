<?php
	session_start();

	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	
	// include('repair_SQL_DATEONLY.php');
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
		
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function checkDel(who,id) {
			var msg = 'Εισαι σίγουρος ότι θέλεις να διαγράψεις την Κατηγορία : '+who+'?';
			if (confirm(msg))
				location.replace('Categories_Sub1_Delete.php?category='+who+'&id='+id);
			}
	</script>
	<!-- ------------------------------------------------------------------------------------------------------------- -->	
	
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
			
			<div class="periheader">
				<h1>Εμφάνιση όλων των Κατηγοριών και υποκατηγοριών</h1>			
			</div>	
			
			<table>
			<tr>
			<td>
			<?php include("jQuery_Tree.php"); ?>		
			</td>
			<td>
			
			<?php				
			//----------------------------------------------------------------------
			//                      Εμφάνιση όλων των Κατηγοριών
			//----------------------------------------------------------------------
						
			include ('db_main.php');
			$sql='SELECT * FROM categories ORDER BY position ASC'; 
			
			$result = $db->query($sql);			
			$numrows = $result->num_rows;
			
			if($numrows==0){
				echo "<div class=center>Δεν υπάρχουν κατηγορίες.</div>";
			}else{
			?>
			<table class="table_categories_show" align="center">
			<caption>Εμφάνιση Κατηγοριών</caption>
			
			<colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">
				<col class="abc3">		
				<col class="abc4">					
			</colgroup>
			
			<tr class="main"> <th>Α/Α</th> <th>catid</th> <th>Κατηγορία</th> <th>Αγγλικά</th> <th>Γερμανικά</th> <th>Υποκατηγορία</th> <th>Θέση</th> </tr> 
			<?php
			
			$i = 1;   // Για τα χρώματα του πίνακα.
			$counter=1;
			while ($row = $result->fetch_assoc()) {	 
			?>					                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
					  <td><?php echo $counter;?>                   </td>
					  <td><?php echo $row['catid']?>               </td> 
					  <td><?php echo $row['catname']?>             </td>
					  <td><?php echo $row['catname_en']?>          </td> 					  
					  <td><?php echo $row['catname_de']?>          </td> 
					  
					  
					  <td>
					  
					  <table class="table_inside" align="center" >
					  <?php //  Δεύτερος Πίνακας για τις υποκατηγορίες........
					  
						  	//$db_2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
							include ('db_main.php');
							$sql_2 = "SELECT * FROM categories_sub1 WHERE catid = ".$row['catid'];
							$result_2 = $db->query($sql_2);
							
							$numrows_2 = $result_2->num_rows;
							if ($numrows_2==0){
								echo "Δεν υπάρχει.";
							}else{
								$counter_2=0;
								while ($row_2 = $result_2->fetch_assoc() ) {
									//echo "<tr class='grami'><td> ".$row_2['subcatname']."</td> <td>".$row_2['position']."</td></tr>";   ?>
									<tr><td><?php echo $row_2['subcatname'] ?></td> <td><?php echo $row_2['position'] ?></td> </tr>									
							<?php		$counter_2++;
								} 
							}
							// ----------------------------------------------------
					  ?>
					  </table>
					  
					  </td>
					                  
				      
					  <td><?php echo $row['position']?>            </td> 
				</tr>			
			
			<?php
				$i++;
				$counter++;
			} // end of : while
				$db->close();	
			} // end of: if($numrows==0){
			?>
			</table>
			</table>
	</div>
	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html> 
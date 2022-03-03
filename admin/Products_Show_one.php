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
	
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function checkDel(who,id) {
  			var msg = 'Are you sure you want to delete : '+who+' με κωδικό : '+id+'?';
  			if (confirm(msg))
    			location.replace('Products_Show_one_Delete.php?title='+who+'&isbn='+id);                 		
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
				<h1>Εμφάνιση συγκεκριμένου προϊόντος</h1>
			</div>	
				
			<?php
			if ($_GET && !$_POST) {
				//----------------------------------------------------------------------
				// get details of record to be edited  -- INSERT TO TEXT                
				//----------------------------------------------------------------------
				$isbn2=$_GET['isbn'];						
				include ('db_main.php');
				$sql = "SELECT * FROM books  WHERE isbn="."'$isbn2'";  // ΠΡΟΣΟΧΗ : είναι αλφαριθμητικό.
				$result = $db->query($sql);
				$numrows = $result->num_rows;
						
				while ($row = $result->fetch_assoc() ) {	 
				?>
			
			
								
							
				
				<table class="table_products_show">
			    <caption><?php echo $i ?></caption>
			    
				
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" >
					<td rowspan="12" width="134" height="237" class="no_color"><?php echo "<img src='" . $row['picture'] . "'  height=237 width=134 >" ?>  </td>					 
				</tr>
								
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >    <th><b>Κωδικός :         </b></th><td><?php echo $row['isbn']?>             </td>
					<td><a href="Products_Show_one_Edit.php?isbn=<?php echo $row['isbn'];?>&catid=<?php echo $row['catid'];?> " >   Επεξεργασία </a>      </td>
					  
				</tr>
				
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Εταιρία :       </b></th><td><?php echo $row['author']?>          </td>
					<td><a href="javascript:checkDel(  '<?php echo addslashes($row['title']); ?>'  ,  '<?php echo $row['isbn']  ; ?>'  )" > Διαγραφή </a>  </td>
				</tr>
				
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >    <th><b>Τίτλος:         </b></th><td><?php echo $row['title']?>              </td></tr>
				
				
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Κατηγορία:     </b></th><td>
													  <?php  // Εμφάνιση της Κατηγορίας που ανήκει το προϊόν.
													  
													  	
														include ('db_main.php');
														$sql_2 = "SELECT * FROM categories WHERE catid = ".$row['catid'];
														$result_2 = $db_2->query($sql_2);
														//$row = $result->fetch_assoc();			
														$numrows_2 = $result_2->num_rows;
														
														$counter=0;
														while ($row_2 = $result_2->fetch_assoc() ) {
															echo $row_2['catname'];															
														} 
													  ?>
				                                       </td></tr>
				
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Υποκατηγορία:     </b></th><td>
													  <?php  // Εμφάνιση της Υποκατηγορίας που ανήκει το προϊόν.
													  
													  	
														include ('db_main.php');
														$sql_3 = "SELECT * FROM categories_sub1 WHERE subcatid = ".$row['subcatid'];
														$result_3 = $db_3->query($sql_3);
														//$row = $result->fetch_assoc();			
														$numrows_3 = $result_3->num_rows;
														
														//$counter=0;
														while ($row_3 = $result_3->fetch_assoc() ) {
															echo $row_3['subcatname'];															
														} 
													  ?>
				                                       </td></tr>
				
				
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Τιμή :      </b></th> <td><?php echo $row['price']?>                       </td></tr>
				
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Παρουσίαση : </b></th> <td><?php echo $row['presentation']?>                 </td></tr>
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Προσφορά :</b></th> <td><?php echo $row['offer']?>   </td></tr>			
				
				
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Orientation :</b></th> <td><?php echo $row['orientation']?>   </td></tr>
				<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Ημερομηνία :</b></th> <td><?php echo repair_SQL_DATEONLY($row['date'])?>   </td></tr>				
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Περιγραφή :</b></th> <td><?php echo $row['description']?>   </td></tr>
			</table>		
				
				
			
			
			<?php
			echo "<br/>";
			} //<-- end of: while
				$db->close();			
			
	} // <-- end of : if ($_GET && !$_POST)
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
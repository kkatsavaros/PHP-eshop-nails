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
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function checkDel(who,id) {
  			var msg = 'Are you sure you want to delete '+who+'?';
  			if (confirm(msg))
    			location.replace('Products_show_one_Delete.php?title='+who+'&isbn='+id);
  		}
	</script>
	<!-- ------------------------------------------------------------------------------------------------------------- -->
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
			
		<div class="periheader">
			<h1>Φόρμα Εύρεσης Προϊόντων</h1>
		</div>	
		
		<table class="table_ProductsToHTML_queries_1o" align="center" >
		<form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">		
		
			<tr><th>Εύρεση ανά Κατηγορία : </th><td>
			<?php  // ------------------------  Πρώτο ComboBox ---------------------------------------
			//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
			include ('db_main.php');
			$sql='SELECT * FROM categories ';
			$result = $db->query($sql);
		
			$numrows = $result->num_rows;
			?>
			
			
			<select name="abc"  id="company" >
	
			<?php		
			
			while ($row = $result->fetch_assoc()) {							
				echo "<option value=".$row['catid']." >" .$row['catname']. "</option>";
			}
				
			$db->close();		
			?>		
			</select>
			</td></tr>
		
		
			<tr><th>Εύρεση ανά Κωδικό(isbn) : </th><td>	<input name="abc3" type="text" class="index">           </td></tr>
			<tr><th>&nbsp;            </th><td><input name="insPublisher" type="submit" id="insPublisher" value="Εύρεση" /></td></tr>
		
		</form>	
		</table>
	
	
	
	<?php
	if ($_POST) {
		print_r($_POST); 
				
		//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
		include ('db_main.php');
		//$sql = 'SELECT * FROM products WHERE category="'.$_POST['abc2'].'" AND company="'.$_POST['abc'].'" ';
		//$sql = 'SELECT * FROM books WHERE catid="'.$_POST['abc'].'"  ';
		$sql = 'SELECT * FROM books WHERE catid="'.$_POST['abc'].'" OR isbn="'.$_POST['abc3'].'" ';
		
		$result = $db->query($sql);	
	
		$numrows = $result->num_rows;
		if($numrows==0){
			$alert="Δεν βρέθηκαν σχετικά προϊόντα.";
		}else{
			$message="Συνολικός αριθμός προϊόντων :".$numrows;
		}
		
		$counter=0;
		while ($row = $result->fetch_assoc()) {	
			$counter++;
		?>
		<table class="table_products_show" align="center">
		<caption><?php echo $counter; ?></caption>
			
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >
				<td rowspan=8 width="120" height="120" class="no_color"><?php echo "<img src='" . $row['picture'] . "'  height=120 width=100 >" ?>  </td>
			</tr>
									
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>isbn: </b></th><td><?php echo $row['isbn']?></td>
			                            <td><?php echo $row['isbn'] ?></td> </tr>				  					  
					
			<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" > <th><b>Εκδότης: </b></th><td><?php echo $row['author']?></td>
			                              <td><a href="Products_show_one_Edit.php?isbn=<?php echo $row['isbn'];?>" >Επεξεργασία </a></td></tr>
					
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Τίτλος: </b></th><td><?php echo $row['title']?></td>
				  <td><a href="javascript:checkDel(  '<?php echo addslashes($row['title']); ?>'  ,  <?php echo $row['isbn']; ?>  )" > Διαγραφή </a></td></tr>	
			
			<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Κατηγορία:</b>            </th><td>
													  <?php 
													  	//$db_2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
														include ('db_main.php');
														$sql_2 = "SELECT * FROM categories WHERE catid = ".$row['catid'];
														$result_2 = $db->query($sql_2);
														//$row = $result->fetch_assoc();			
														$numrows_2 = $result_2->num_rows;
														
														while ($row_2 = $result_2->fetch_assoc() ) {
															echo $row_2['catname'];															
														} 
													  ?>
				                                       </td></tr>				
					
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Τιμή:       </b>         </th><td><?php echo $row['price']?>                     </td></tr>
			<tr class="<?php echo $i-1%2 ? 'nohilite' : 'hilite'; ?>" ><th><b>Περιγραφή:  </b>         </th><td><?php echo $row['description']?>               </td></tr>
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>" >  <th><b>Ημερομηνία: </b>         </th><td><?php echo repair_SQL_DATEONLY($row['date'])?> </td></tr>			
		</table>		
		
			
			
		<?php
			
			echo "<br>";
		}
				
		$db->close();		
		}
		
		?>	
		<div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
		<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
		
	</div>
	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
<?php
	session_start();
	
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	include('repair_SQL_DATEONLY.php');
	
	$ShowAllOrders=true;
?>

<?php
	if($_GET['ok']){	
		$message="<div id=red_alert>"." Έχει γίνει η διαγραφή της παραγγελίας."."</div>";
	}
?>

<?php
	//********************************************************************************************
	//							Πατήθηκε το κουμπί "Go"
	//********************************************************************************************
	
	// Επιλέγεται νέο βιβλίο. --->"new=Το isbn του βιβλίου."
	if($_POST['update_order_status']){
		//print $_GET['new'];
		//print_r($_POST);
		//echo "<br>";
		
		
		include ('db_main.php');
		$sql = 'UPDATE orders SET order_status = "'.trim($_POST['abc']).'"  ';
			
		$sql .= 'WHERE orderid = '.$_POST['hidden'];
			
		$result = $db->query($sql);
							
				
		if ($result) {
			$result_update="Εγινε η ανανέωση";
		} else {
			$result_update="Δεν έγινε η ανανέωση.";
		}
	}
?>


<?php
	//********************************************************************************************
	//							Πατήθηκε το κουμπί "Διαγραφή παραγγελιών"
	//********************************************************************************************
	
	// Επιλέγεται νέο βιβλίο. --->"new=Το isbn του βιβλίου."
	if($_POST['orders_delete']){
		//print $_GET['new'];
		//print_r($_POST);
		//echo "<br>";
	
		/*$c=array_keys($_POST);		 
		print_r($c);    
		echo "<br>";*/		
		
		$mikos_pinaka=count($_POST);
		//echo "Μήκος πίνακα : ".$mikos_pinaka;
		//echo "<br>";
		
		// Οταν υπάρχει γράμμα ή αριθμός από 0 δεν υπάρχει πρόβλημα. 
		// Αν ξεκινάει από άλλο νούμερο τότε βγάζει λάθος. ακου να δεις τι γίνεται το μαλακισμένο.
		$post=$_POST;		
    	$c2=array_slice( $post,   0  , $mikos_pinaka-1); // Ασε από στον πίνακα c από το 0(πρώτο στοιχείο μέχρι το όλα πριν το τελευταίο.)
		//echo "Βγάζω το τελευταίο : ";
		//print_r($c2);    echo "<br>";
			
		
		/*$c3=array_keys($c2);	// Αναποδογυρίζει τον πίνακα.	 
		print_r($c3);    
		echo "<br>";*/		
		
		$i=0;   //Μετρητής διαγραφών.
		foreach($c2 as $isbn=>$qty){
			
			//echo $isbn." --> ".$qty."<br>";
			
			
			include ('db_main.php');
			$sql = 'DELETE FROM orders WHERE orderid = '.$qty;
			$result= $db->query($sql);
			
			
			if ($result) {
				//header('Location: Orders.php?delete=ok?');
				//exit();
				$a="ok";
				echo $numrows;
			} else{
				//header('Location: Orders.php?delete=not?');
				//exit();
				$b="not";
			}
			
			$i++;			
		}
			$db->close();
	}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<A NAME="top"></A>
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
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγράψεις την παραγγελία του :  '+who+';';
			if (confirm(msg))
				location.replace('Orders_Delete.php?order='+who+'&orderid='+id);
			}
	</script>
	<!-- ------------------------------------------------------------------------------------------------------------- -->	
	
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	<!-- Για το jQuery Datepicker Plugin-->
    <style type="text/css">	@import "jQuery_DatePicker/css/humanity.datepick.css"; 	</style>
    
	<script type="text/javascript" src="jQuery_DatePicker/js/jquery.js">            </script>
	<script type="text/javascript" src="jQuery_DatePicker/js/jquery.datepick.js">   </script>
	<script type="text/javascript" src="jQuery_DatePicker/js/jquery.datepick-el.js"></script>
    
    <script type="text/javascript">
		$(function() {
			$('#popupDatepicker1').datepick();	
		});
		
		$(function() {
			$('#popupDatepicker2').datepick();	
		});		
	</script>
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	
	<!-- ------------------------------------------------------------------------------------------------------------- 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>--> 
	<script type="text/javascript">
            $(document).ready(function(){
            	 $("#checkall").click(function(){
            	 	   $("#checkboxes").find(":checkbox").attr("checked",this.checked);
            	 });
            })
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
					// include("Menu_Admin.php");	
				?>
			</div>
	</div>

	<div id="columnRight_orders_only">
	
		<div class="periheader">
				<h1>Φόρμα Παραγγελιών..</h1>
		</div>	
		
		<?php/*
		$date1 = new DateTime();
		$message.="Ημερομηνία : ".$date1->format("l j-n-Y ")."<br>";
		$message.="Ωρα : ".$date1->format("H:i:s")."<br><br>";
		
		echo $message;*/
		?>
		
		<?php
		//------------------------------------------------------------------------------------------------------------------------------------
		// 													Φόρμα Εύρεσης μεταξύ Ημερομηνιών
		//------------------------------------------------------------------------------------------------------------------------------------		
		?>       
        
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		
			<table class="table_between_dates" align="center">
				<tr>
					<td><input type="text" id="popupDatepicker1" name="abc1"  class="searchtext" value="κάνε κλικ εδώ"></td>                    
                    <td><input type="text" id="popupDatepicker2" name="abc2"  class="searchtext" value="κάνε κλικ εδώ"></td>                    
                    <td><input  type="submit" name="find" value="Εύρεση" /></td>
				
					<td><input  type="submit" name="find2" value="Ολες οι Παραγγελίες" /></td>
				<tr>
				
			</table>
		</form>
		
				
		
		 <?php
		//--------------------------------------------------------------------------------------------------------
		// 							Πίνακας αποτέλεσμα εύρεσης μεταξύ των ημερομηνιών
		//--------------------------------------------------------------------------------------------------------
		if($_POST['find']){
			//print_r($_POST);
			// echo "<br>";	
			
			if (($_POST['abc1']=='κάνε κλικ εδώ') or ($_POST['abc1']=='κάνε κλικ εδώ')){ 
				$date1=date("Y-m-d");
				$date2=date("Y-m-d");
			}else {		
				$date1=date( "Y-m-d",strtotime($_POST['abc1']) );  // Μετατροπή σε format για την MySQL δηλαδή YY-MM-dd
				$date2=date( "Y-m-d",strtotime($_POST['abc2']) );		
		    }
			
				
			//echo strtotime($date1);   // Μετατροπή σε Timestamp.
			//echo "<br>";
			//echo strtotime($date2);		
					
			if($date1>$date2){
				$message=" Θέλεις αναζήτηση μεταξύ των ημερομηνιών : ".repair_SQL_DATEONLY($date1)."    και   ".repair_SQL_DATEONLY($date2);
				$alert= "Η πρώτη ημερομηνία πρέπει να είναι μικρότερη από την δεύτερη ημερομηνία";
				
                ?>
				<div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
				<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>  
                <?php
				
			}else{
				
				
				
				include ('db_main.php');
				$sql="SELECT * FROM orders WHERE date>='".$date1."' and date<='".$date2."' ORDER BY orderid DESC"; 
				
				$result = $db->query($sql);				
				$sinolo_paragelion = $result->num_rows;
				
				if ($sinolo_paragelion==0){
					echo "<div id='fouxi'>";
					echo "Από  ".repair_SQL_DATEONLY($date1)." μέχρι  ".repair_SQL_DATEONLY($date2). "  δεν υπάρχουν παραγγελίες";
					echo "</div>";
					
				}else{
					
				
				
				
				echo "<div id='fouxi'>";
				echo "Σύνολο παραγγελιών από  ".repair_SQL_DATEONLY($date1)." μέχρι  ".repair_SQL_DATEONLY($date2). "  =  ".$sinolo_paragelion;
				echo "</div>";
				?>
                
				
				
                
                <div id="blue"> <?php if(isset($a)) echo "Η διαγραφή των ".$i."  παραγγελιών πραγματοποιήθηκε."; ?> </div>
				<div id="red_alert">  <?php if(isset($b)) echo "Προσοχή : Υπάρχει κάποιο πρόβλημα η διαγραφή δεν έγινε." ?>   </div>
			    <div id="red_alert">  <?php if(isset($result_update)) echo $result_update; ?>   </div>           
                
				
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">     
				
				<div id="checkboxes">
                <table class="table_orders" align="center">
                <caption><?php echo repair_SQL_DATEONLY($date1)." μέχρι ".repair_SQL_DATEONLY($date2); ?></caption>
                <colgroup>
                    <col class="abc1"><col class="abc2"><col class="abc3"><col class="abc4"><col class="abc5">	
                    <col class="abc6"><col class="abc7"><col class="abc8"><col class="abc9"><col class="abc9">
					<col class="abc9"><col class="abc9"><col class="abc9"><col class="abc9"><col class="abc9">
				</colgroup>
            
		    <caption>Ολες οι παραγγελίες</caption>
				<tr><th width="5" class="w">Α/Α</th>     <th width="5" class="w">Order id</th>     <th width="5" class="w">Customer id</th>
				
				<th width="5" class="w">amount</th><th width="5" class="w">Ημερομηνία</th><th width="5" class="w">Ωρα</th>

				<th width="120" class="w">Κατάσταση</th>
				<th class="w">Όνομα Απ.</th><th class="w">Επίθετο Απ.</th>
				<th class="w">Διεύθυνση Απ.</th><th class="w">Πόλη Απ.</th><th class="w">ΤΚ Απ.</th><th class="w">Χώρα Απ.</th>
				<th>&nbsp;</th><th>Διαγραφή<input type="checkbox" id="checkall" ></th></tr>
		<?php	
			$i = 1;
			while ($row = $result->fetch_assoc()) {					
		?>
		
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
				
				<td><?php echo $i ?></td>
				<td><?php echo $row['orderid']; ?></td>
				<td><?php echo $row['customerid']; ?></td>
				
				<td><?php echo $row['amount'];  ?></td>
				<td width="80"><?php echo repair_SQL_DATEONLY($row['date']); ?></td>
				<td><?php echo $row['time'];  ?></td>
				
				
				<td>
					<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"> <!--  ---------------------------------------------------------------------------- πάνω -->
						<select name="abc"  class="update_order_status">						
									<option value="<?php echo $row['order_status']; ?>">   <?php echo $row['order_status']; ?>   </option>
									
									<option value="
									<?php
									if (trim($row['order_status'])=='NOT COMPLETED') {
										echo 'COMPLETED';
										$value='COMPLETED';
									}
									if (trim($row['order_status'])=='COMPLETED') {
										echo 'NOT COMPLETED';
										$value='NOT COMPLETED';
									}
									
									?>							
									"> <?php echo $value;  ?></option>
									
									<input type="hidden"  name="hidden" value="<?php echo $row['orderid']; ?>"/>
									<input class="button" name="update_order_status" type="submit" value="Go" />
						</select>	
					</form>				
				</td>
				
				
				<td><?php echo $row['ship_name']; ?></td>
				<td><?php echo $row['ship_surname']; ?></td>
				<td><?php echo $row['ship_address']; ?></td>
				<td><?php echo $row['ship_city']; ?></td>
				<td><?php echo $row['ship_zip']; ?></td>
				<td><?php echo $row['ship_country']; ?></td>		
				
			
				<td><a href="Order_Items.php?num=<?php echo $row['orderid']."&who=".$row['ship_surname']; ?>" >Παραγγελία</a></td>
				<!-- td><a href="javascript:checkDel(  '<?php //echo addslashes($row['ship_name']); ?>'  ,  <?php //echo $row['orderid']; ?>  )">Διαγραφή</a></td -->
				<td> <input type="checkbox" name="<?php echo $row['orderid']; ?>" value="<?php echo $row['orderid']; ?>"> </td>
					
			</tr> 			
           
			
			<?php
				$i++;
				
			} // end of : while
			$db->close();	
                               
				} // end of : if ($sinolo_paragelion==0){
			} // end of : if($w1>$w2){
		?>
			
			<tr width="800px">				
				<td colspan="15"><input class="button" name="orders_delete" type="submit" value="Διαγραφή παραγγελιών" />
				</td>
			</tr>	
		</table>
		</div> <!-- <div id="checkboxes"> -->
		</form>
		
		<?php
		}  else  {   // του  : if($_POST['find']){	
		//--------------------------------------------------------------------------------------------------------------------------------------------------------
		//             Αρχικά όλες οι παραγγελίες συνολικά.
		//                 όταν φορτώνεται η σελίδα.
		//--------------------------------------------------------------------------------------------------------------------------------------------------------
		?>
        		
		                                                           
		<div id="blue"> <?php if(isset($a)) echo "Η διαγραφή των ".$i."  παραγγελιών πραγματοποιήθηκε."; ?> </div>
		<div id="red_alert">  <?php if(isset($b)) echo "Προσοχή : Υπάρχει κάποιο πρόβλημα η διαγραφή δεν έγινε." ?>   </div>
		<div id="red_alert">  <?php if(isset($result_update)) echo $result_update; ?>   </div>
			
		
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<?php
				
			include ('db_main.php');
			$sql = 'SELECT * FROM orders ORDER BY orderid DESC';
			$result = $db->query($sql);		
			$numrows = $result->num_rows;			
			
			if($numrows==0){
				echo "<div id=red_alert> Δεν υπάρχουν παραγελίες. </div>";
			}else{
				
			echo "<div id='fouxi'>";
			echo "Σύνολο παραγγελιών : ".$numrows;
			echo "</div>";	
				
		?>
			<div id="checkboxes">
			<table class="table_orders" align="center">
			
			<colgroup>
				 <col class="abc1"><col class="abc2"><col class="abc3"><col class="abc4"><col class="abc5">	
                 <col class="abc6"><col class="abc7"><col class="abc8"><col class="abc9"><col class="abc9">
				 <col class="abc9"><col class="abc9"><col class="abc9"><col class="abc9"><col class="abc9">
			</colgroup>
			
			<caption>Ολες οι παραγγελίες..</caption>
				<tr><th width="50" class="w">Α/Αm</th>     <th width="5" class="w">Order id</th>     <th width="5" class="w">Customer id</th>
				
				<th width="5" class="w">amount</th><th width="5" class="w">Ημερομηνία</th><th width="5" class="w">Ωρα</th>

				<th width="200">Κατάσταση</th>
				<th class="w">Όνομα Απ.</th><th class="w">Επίθετο Απ.</th>
				<th class="w">Διεύθυνση Απ.</th><th class="w">Πόλη Απ.</th><th class="w">ΤΚ Απ.</th><th class="w">Χώρα Απ.</th>
				<th>&nbsp;</th><th>Διαγραφή<input type="checkbox" id="checkall" ></th></tr>
		<?php
		
			$i = 1;
			while ($row = $result->fetch_assoc()) {			
		
			/*
			//-----------------------------------------------------------------
			//  Τσιμπάω την τιμή του email από τον πίνακα customers
			//----------------------------------------------------------------
			/*
			include ('db_main.php');
			$sql_2 = 'SELECT * FROM customers WHERE email = '.$row['customerid'];
			$result_2 = $db_2->query($sql_2);		
			$numrows = $result_2->num_rows;			
			
			while ($row_2 = $result_2->fetch_assoc()) {			
					
				$email= $row_2['email'];
				//echo $email;
			}
			
			$db_2->close();
			
			//--------------------------------------------------------------------
			*/
		?>
		
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
				
				<td><?php echo $i ?></td>
				<td><?php echo $row['orderid']; ?></td>
				<td><?php echo $row['customerid']; ?></td>
				
				<td><?php echo $row['amount'];  ?></td>
				<td width="80"><?php echo repair_SQL_DATEONLY($row['date']); ?></td>
				<td><?php echo $row['time'];  ?></td>
				
				<td>				
					<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"> <!--  ---------------------------------------------------------------------------- κάτω -->
						<select name="abc"  class="update_order_status">						
									<option value="<?php echo $row['order_status']; ?>">   <?php echo $row['order_status']; ?>   </option>
									
									<option value="
									<?php
									if (trim($row['order_status'])=='NOT COMPLETED') {
										echo 'COMPLETED';
										$value='COMPLETED';
									}
									if (trim($row['order_status'])=='COMPLETED') {
										echo 'NOT COMPLETED';
										$value='NOT COMPLETED';
									}
									
									?>							
									"> <?php echo $value;  ?></option>
									
									<input type="hidden"  name="hidden" value="<?php echo $row['orderid']; ?>"/>
									<input class="button" name="update_order_status" type="submit" value="Go" />
						</select>	
					</form>	
				</td>
				
				
				<td><?php echo $row['ship_name']; ?></td>
				<td><?php echo $row['ship_surname']; ?></td>
				<td><?php echo $row['ship_address']; ?></td>
				<td><?php echo $row['ship_city']; ?></td>
				<td><?php echo $row['ship_zip']; ?></td>
				<td><?php echo $row['ship_country']; ?></td>		
				
			
				<td><a href="Order_Items.php?num=<?php echo $row['orderid']."&who=".$row['ship_surname']; ?>" >Παραγγελία</a></td>
				<!-- td><a href="javascript:checkDel(  '<?php //echo addslashes($row['ship_name']); ?>'  ,  <?php //echo $row['orderid']; ?>  )">Διαγραφή</a></td -->
				<td> <input type="checkbox" name="<?php echo $row['orderid']; ?>" value="<?php echo $row['orderid']; ?>"> </td>
					
			</tr>
				
		<?php
			$i++;
			
			
			}// end of while :		
		?>
			
				<tr width="800px">				
					<td colspan="15"><input class="button" name="orders_delete" type="submit" value="Διαγραφή παραγγελιών" />
					</td>
				</tr>	
				
		</table>	
		</div> <!-- <div id="checkboxes"> -->
		</form>
		
		
		<?php
			}// end of if :
			$db->close();
		
		} // end of : // του  : if($_POST['find']){		
		?>
	
		<a href="#top">πάνω</a>
	
	</div>
	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
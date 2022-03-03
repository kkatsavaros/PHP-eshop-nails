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
		$message="<br>"." Έχει γίνει η διαγραφή του πελάτη."."<br><br>";
	}
?>

<?php
	//********************************************************************************************
	//							Πατήθηκε το κουμπί "Διαγραφή Πελατών"
	//********************************************************************************************
	
	// Επιλέγεται νέο βιβλίο. --->"new=Το isbn του βιβλίου."
	if($_POST['customers_delete']){
		//print $_GET['new'];
		//print_r($_POST);
		//echo "<br>";
	
		/*$c=array_keys($_POST);		 
		print_r($c);    
		echo "<br>";*/		
		
		$mikos_pinaka=count($_POST);
		//echo "Μήκος πίνακα : ".$mikos_pinaka;
		//echo "<br>";
		
		
		if ($mikos_pinaka==1){  // Ελεγχος αν έχει επιλέξει πελάτη ή έχει πατήσει το κουμπί διαγραφή από μόνο του.
			$no_customers="not";			
			
		} else{
		
		
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
			$sql = 'DELETE FROM customers WHERE customerid = '.$qty;
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
			
		} //end of: if ($mikos_pinaka==1){
	} //end of: if($_POST['customers_delete']){
?>

<?php

	if($_POST['find']){
		//print_r($_POST);
		
		
		$date1=$_POST['date13']."-".$_POST['date12']."-".$_POST['date11'];
		$date2=$_POST['date23']."-".$_POST['date22']."-".$_POST['date21'];				
		
		$w1=mktime(0,0,0,$_POST['date12'],$_POST['date11'],$_POST['date11']);
		$w2=mktime(0,0,0,$_POST['date22'],$_POST['date21'],$_POST['date21']);
		
		echo "w1 : ".$w1;
		echo "<br>";
		echo "w2 : ".$w2;
		
		if($w1>$w2){
			//$alert= "Η πρώτη ημερομηνία πρέπει να είναι μικρότερη από την δεύτερη ημερομηνία";
		}
		
	}
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
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγραφεί ο πελάτης : '+who+';';
			if (confirm(msg))
				location.replace('Customer_Delete.php?surname='+who+'&customerid='+id);
			}
	</script>
	
	
	<!-- ------------------------------------------------------------------------------------------------------------- -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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
				<h1>Φόρμα Πελατών</h1>
		</div>	
		
		                                                           
		<div id="blue"> <?php if(isset($a)) echo "Η διαγραφή των ".$i."  πελατών πραγματοποιήθηκε."; ?> </div>
		<div id="red_alert">  <?php if(isset($b)) echo "Προσοχή : Υπάρχει κάποιο πρόβλημα η διαγραφή δεν έγινε." ?>   </div>
		<div id="red_alert">  <?php if(isset($no_customers)) echo "Προσοχή : Δεν έχεις επιλέξει πελάτες για διαγραφή." ?>   </div>
			
		
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">		
		<?php			
			//--------------------------------------------------------------------------------------------------------------------------------------------------------
			//             Αρχικά όλοι οι πελάτες συνολικά.
			//                 όταν φορτώνεται η σελίδα.
			//--------------------------------------------------------------------------------------------------------------------------------------------------------
		
		
			include ('db_main.php');
			$sql = 'SELECT * FROM customers ORDER BY customerid DESC';
			$result = $db->query($sql);		
			$numrows = $result->num_rows;			
			
			if($numrows==0){
				echo "<div id=red_alert> Δεν υπάρχουν παραγελίες. </div>";
			}else{
		?>
			<div id="checkboxes">
			<table class="table_customers" align="center">
			
			<colgroup>
				<col id="abc"><col id="abc"><col id="abc"><col id="abc"><col id="abc"><col id="abc">
				<col id="abc"><col id="abc"><col id="abc"><col id="abc"><col id="abc"><col id="abc">
				<col id="abc"><col id="abc"><col id="abc">
			</colgroup>
			
			<caption>Ολοι οι πελάτες</caption>
				<tr><th width="5" class="w">Α/Α</th>     <th width="5" class="w">Customer id</th>
				<th width="5" class="w">Όνομα</th>      <th width="5" class="w">Επίθετο</th>    <th width="5" class="w">Διεύθυνση</th>
				<th width="5" class="w">Πόλη</th>  <th width="120" class="w">Ταχ. Κώδικας</th>
				<th class="w">Χώρα</th><th class="w">email</th><th class="w">Τηλέφωνο</th>
				<th>&nbsp;</th><th>Διαγραφή <input type="checkbox" id="checkall" ></th></tr>
				
				
		<?php
		
			$i = 1;
			while ($row = $result->fetch_assoc()) {			
				
		?>
		
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
				
				<td><?php echo $i ?></td>
			
				<td><?php echo $row['customerid']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['surname']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['city']; ?></td>
				<td><?php echo $row['zip']; ?></td>
				<td><?php echo $row['country']; ?></td>	
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['telephone']; ?></td>					
				
				
			
				<td><a href="Customer_All.php?num=<?php echo $row['email']; ?>" >Παραγγελίες του</a></td>
				<!-- td><a href="javascript:checkDel(  '<?php echo addslashes($row['surname']); ?>'  ,  <?php echo $row['customerid']; ?>  )">Διαγραφή</a></td -->	
				
				
				<td> <input type="checkbox" name="<?php echo $row['customerid']; ?>" value="<?php echo $row['customerid']; ?>"> </td>
				
			</tr>
				
		<?php
			$i++;
			
			
			}// end of while :
			
		?>
				<tr width="800px">				
					<td colspan="15"><input class="button" name="customers_delete" type="submit" value="Διαγραφή πελατών" />
					</td>
				</tr>	
		
		
		</table>
		</div>	<!-- <div id="checkboxes"> -->
		</form>
		
		<?php
			}// end of if :
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
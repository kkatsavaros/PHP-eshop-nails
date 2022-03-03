<?php
session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

include('repair_SQL_DATEONLY.php');



  


//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκα  1. admin
//----------------------------------------------------------------------		

if($_POST['clear_table_admin']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM admin';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert1="Τα δεδομένα του πίνακα admin διαγράφηκαν.";					
			
		}
		$db->close();
}

//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκα  1. books
//----------------------------------------------------------------------		

if($_POST['clear_table_books']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM books';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert2="Τα δεδομένα του πίνακα books διαγράφηκαν.";					
			
		}
		$db->close();
}

//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκα  3. categories
//----------------------------------------------------------------------		

if($_POST['clear_table_categories']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM categories';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert3="Τα δεδομένα του πίνακα categories διαγράφηκαν.";					
			
		}
		$db->close();
}

//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκα  4. categories_sub1
//----------------------------------------------------------------------		

if($_POST['clear_table_categories']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM categories_sub1';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert4="Τα δεδομένα του πίνακα categories_sub1 διαγράφηκαν.";					
			
		}
		$db->close();
}




//----------------------------------------------------------------------
//            Διαγραφή δεδομένων πινάκων  5. customers
//----------------------------------------------------------------------		

if($_POST['clear_table_customers']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM customers';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert5="Τα δεδομένα του πίνακα customers διαγράφηκαν.";					
			
		}
		$db->close();
}


//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκων  6. orders
//----------------------------------------------------------------------		

if($_POST['clear_table_orders']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM orders';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert6="Τα δεδομένα του πίνακα orders διαγράφηκαν.";					
			
		}
		$db->close();
}


//----------------------------------------------------------------------
//             Διαγραφή δεδομένων πινάκων  7. order_items
//----------------------------------------------------------------------		

if($_POST['clear_table_orders']){
	
	//print_r($_POST);
	
		include ('db_main.php');
		$sql= 'DELETE FROM order_items';
		$result= $db->query($sql);
			
		if ($result) {
									
			$alert7="Τα δεδομένα του πίνακα order_items διαγράφηκαν.";					
			
		}
		$db->close();
}




//----------------------------------------------------------------------
//         Διαγραφή της ip μου στον  πινάκα statistics 
//----------------------------------------------------------------------		
	
if (isset($_POST['myip'])) {
	print_r($_POST);
	
		
   	include ('db_main.php');
	$sql = 'DELETE FROM statistics WHERE ip = "'.$_POST['myip'].'"';		
	$result = $db->query($sql);
	$numrows = $result->num_rows;
			
	echo "------------->".$numrows;
	
	if($result){
		$alert8="Διαγράφηκαν συνολικά : ".$numrows." διευθύνσεις με ip : ".$_POST['myip'];				
	}else{				
		$alert8="Δεν έγιναν διαγραφές";		
	}
				
	$db->close();
	
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
	
	
	
	 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
       <!--<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>-->
       <script type="text/javascript">
            $(document).ready(function(){
            	 $("#checkall").click(function(){
            	 	   $("#checkboxes").find(":checkbox").attr("checked",this.checked);
            	 });
            })
       </script>
	
	
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
			<h1>Καθαρισμός πινάκων</h1>
	</div>
	
	<div id="blue"> <?php if(isset($a)) echo "Η διαγραφή των ".$i."  παραγγελιών πραγματοποιήθηκε."; ?> </div>
	<div id="red_alert">  <?php if(isset($alert8)) echo $alert8; ?>   </div>
	
	
	<?php
			//----------------------------------------------------------------------
			//                    Διαγραφή δεδομένων πινάκων
			//----------------------------------------------------------------------			
			?>
			 <div id="checkboxes">

			
			<table class="table_clear_db" align="center">
			<caption>Διαγραφή Πίνακα customers</caption>
				<form name="myform" id="kati" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">				
				
				<tr><th></th><td><input type="checkbox" id="checkall" >  </td></tr>    <!-- 2 -->
				
				<tr><th>Διαγραφή Πίνακα admin : </th><td><input type="checkbox" name="clear_table_admin" value="kati1"></td></tr>
				
				<tr><th>Διαγραφή Πίνακα books : </th><td><input type="checkbox" name="clear_table_books" value="kati2"></td></tr>
				
				<tr><th>Διαγραφή Πίνακα categories : </th><td><input type="checkbox" name="clear_table_categories" value="kati3"></td></tr>
				
				<tr><th>Διαγραφή Πίνακα categories_sub1 : </th><td><input type="checkbox" name="clear_table_categories_sub1" value="kati4"></td></tr>				
				
				<tr><th>Διαγραφή Πίνακα customers : </th><td><input type="checkbox" name="clear_table_customers" value="kati5"></td></tr>
				
				<tr><th>Διαγραφή Πίνακα orders : </th><td><input type="checkbox" name="clear_table_orders" value="kati6"></td></tr>
				
				<tr><th>Διαγραφή Πίνακα orders_items : </th><td><input type="checkbox" name="clear_table_order_items" value="kati7"></td></tr>
			
				<tr>
					<td><input name="clear_tables_checked" type="submit" id="kati" value="Διαγραφή" /></td>
				</tr>				
					
				</form>
			</table>
			
			</div>
			
			

			<table class="table_clear_db" align="center">
			<caption>Διαγραφή της ip μου από τον πίνακα statistics</caption>
				<form name="myform" id="kati" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">		
				
				<tr>
					<td><input type="text" name="myip" size="15"  align="middle" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				</tr>
				
				<tr>
					<td><input name="clear_myip_from_statistics" type="submit" id="kati" value="Διαγραφή" /></td>
				</tr>				
					
				</form>
			</table>
				


			
			
			

			
			<div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
			
			
			<?php 
			echo "<table class='table_show_cart' align='center' border='0' width='550'>";
			if(isset($alert1)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert1.  "<th></tr></div>";
			if(isset($alert2)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert2.  "<th></tr></div>";
			if(isset($alert3)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert3.  "<th></tr></div>";
			if(isset($alert4)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert4.  "<th></tr></div>";
			if(isset($alert5)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert5.  "<th></tr></div>";
			if(isset($alert6)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert6.  "<th></tr></div>";
			if(isset($alert7)) echo "<div id='red_alert'><tr align='left'><th> Προσοχή : " .$alert7.  "<th></tr></div>";
			echo"</table>";
			?> 
			 			
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>


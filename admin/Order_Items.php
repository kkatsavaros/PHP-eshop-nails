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
	if($_GET['num']){
		//print_r($_GET);
		
		/*
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
		*/
		
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
			var msg = 'Are you sure you want to delete '+who+'?';
			if (confirm(msg))
				location.replace('Orders_Delete.php?order='+who+'&orderid='+id);
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
				<h1>Φόρμα Παραγγελιών</h1>
		</div>	
		<?php
		
		
		
		
		
		
		if($_GET['num']){
			//print_r($_GET);
		
			include ('db_main.php');
			$sql = "SELECT * FROM order_items  WHERE orderid = ".$_GET['num'];
			$result = $db->query($sql);		
			$numrows = $result->num_rows;			
			
			if($numrows==0){
				echo "<div id=red_alert> Δεν υπάρχουν παραγελίες υλικά. </div>";
			}else{
		?>
			<table class="table_orders_items" align="center">
			
			<caption>Παραγγελία <?php echo  $_GET['num']; ?> του πελάτη <?php echo  $_GET['who']; ?></caption>
			
				<tr><th class="w">Α/Α</th><th class="w">Order id</th><th class="w">Κωδικός</th><th class="w">Τιμή είδους</th><th class="w">Ποσότητα</th><th class="w">Σύνολο</th>

				</tr>
		<?php
			$i = 1;
			while ($row = $result->fetch_assoc()) {			
		?>
		
			<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
				
				<td><?php echo $i ?></td>
				<td><?php echo $row['orderid']; ?></td>
				<td><?php echo $row['isbn']; ?></td>
				
				
				<td><?php echo $row['item_price']; ?></td>
				<td><?php echo $row['quantity']; ?></td>
				<td><?php echo ($row['item_price'] * $row['quantity']); ?>
					
			</tr>
				
		<?php
			
			
			
			$sinolo=$sinolo+($row['item_price'] * $row['quantity']);
			$i++;
			}
			
			$db->close();
			}
		
		?>
		</table>	
		
		 
		
		<?php
	}
	
			echo "<div id=red_alert><br><br> Συνολική παραγγελία : $sinolo  €</div>";
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
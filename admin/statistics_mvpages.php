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
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγράψεις την παραγγελία του :  '+who+';';
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
				<h1>Επισκεψιμότητα σελίδων</h1>
		</div>	
		
		
		
		<?php 
		//------------------------------------------------------------------------------------------------------------------------------------
		// 		                                 Οι πιο επισκέψιμες σελίδες - most visited pages			
		//------------------------------------------------------------------------------------------------------------------------------------
		
		include ('db_main.php');			
		$sql="SELECT page, COUNT(*) FROM statistics GROUP BY page ORDER BY count(*) DESC";
							
		$result = $db->query($sql);
		$numrows = $result->num_rows;
		?>
                
		<table class="table_statistics_show_mvpages" align="center">
		<caption>Οι πιο επισκέψιμες σελίδες</caption>
			
			<colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">		
				<col class="abc5">				
			</colgroup>
			
			<tr class="main"> <th width='50'>Α/Α</th> <th width='700'>Page</th><th>Επισκέψεις</th width='50'></tr> 
			<?php
			
			$i = 1;   // Για τα χρώματα του πίνακα.
			
			while ($row = $result->fetch_assoc()) {	 
			?>					                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
					<td class="a1" >               <?php echo $i;              ?>       </td> 	
					<td class="a2" align="left">   <?php echo $row['page']; ?>          </td>
                    <td class="a3" >               <?php echo $row['COUNT(*)']; ?>      </td>
                    
				</tr>			
			
			<?php
				$i++;
				
			} // end of : while
			$db->close();	
			//} // end of: if($numrows==0){ */
			?>
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
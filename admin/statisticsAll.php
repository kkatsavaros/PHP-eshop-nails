<?php
	session_start();
	
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	include('repair_SQL_DATEONLY.php');
	
	$ShowAllOrders=true;
	
	
	//------------------------------------------------------------------------------------------------------------------------------------
	// 												Εύρεση όλων των χτυπημάτων συνολικά
	//------------------------------------------------------------------------------------------------------------------------------------			
	include ('db_main.php');			
	$sql="SELECT * FROM statistics";
						
	$result = $db->query($sql);
	$numrows_sinolo = $result->num_rows;	
	$db->close();	
	
	//------------------------------------------------------------------------------------------------------------------------------------
	// 													Εύρεση μοναδιαίων χτυπημάτων
	//------------------------------------------------------------------------------------------------------------------------------------		
	include ('db_main.php');			
	$sql  =  "SELECT DISTINCT(ip) FROM statistics";
							
	$result = $db->query($sql);
	$numrows_unique_visitors = $result->num_rows;		
	$db->close();
	
	//------------------------------------------------------------------------------------------------------------------------------------
	// 														Εύρεση αραχνών
	//------------------------------------------------------------------------------------------------------------------------------------		
	include ('db_main.php');			
	$sql  =  "SELECT * FROM statistics WHERE crawler_name='a1' ";
							
	$result = $db->query($sql);
	$numrows_crawler = $result->num_rows;		
	$db->close();	
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
				<h1>Στατιστικά www.artofnails.biz</h1>
		</div>	
		
		
		
		
		<div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
		<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
		
		
		    <table class="table_statistics_show" align="center">
			<caption> Συνοπτικά - Summary</caption>
			
			<colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">		
				<col class="abc5">				
			</colgroup>
			
			<tr class="main">  <th>Σύνολο χτυπημάτων</th> <th>Σύνολο μοναδιαίων χτυπημάτων</th> <th>Αράχνες</th></tr>
            
            <tr> <td><div id="blue"> <?php if(isset($numrows_sinolo))          echo $numrows_sinolo; ?> </div>                     </td>
                 <td><div id="blue"> <?php if(isset($numrows_unique_visitors)) echo $numrows_unique_visitors ?> </div>             </td>
                 <td><div id="blue"> <?php if(isset($numrows_crawler))         echo $numrows_crawler ?> </div>                     </td>
            </tr>            
		</table>
		
		<?php
		
		
		//------------------------------------------------------------------------------------------------------------------------------------
		// 													Εμφάνιση του πίνακα αρχικά
		//------------------------------------------------------------------------------------------------------------------------------------		
		
		include ('db_main.php');			
		$sql="SELECT * FROM statistics ORDER BY date DESC, time DESC LIMIT 700";
							
		$result = $db->query($sql);
		$numrows = $result->num_rows;
		        
        if($numrows==0){
				echo "<div class=center>Δεν υπάρχουν χτυπήματα.</div>";
		}else{
				
			$hits=$numrows;
			
			?>
            
			<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?></div>
            
			<table class="table_statistics_show" align="center">
			<caption>Στατιστικά</caption>
			
			<colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">		
				<col class="abc5">
                <col class="abc6">	
                <col class="abc7">
                <col class="abc8">	
                <col class="abc9">			
			</colgroup>
			
			<tr class="main"> <th>Α/Α</th> <th>Browser</th> <th>IP</th> <th>Page</th> <th>Date</th> <th>Time</th> <th>Χώρα</th> <th>Σημαία</th> <th>crawler_name</th>
            <th>crawler_bool</th> </tr>
			<?php
			
			$i = 1;   // Για τα χρώματα του πίνακα.
			
			while ($row = $result->fetch_assoc()) {	 
			?>					                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
					<td class="a1"><?php echo $i              ?>                      </td> 	
					<td class="a2"><?php echo $row['browser'] ?>                      </td> 
					<td class="a3"><?php echo $row['ip']      ?>                      </td>
					<td class="a4"><?php echo $row['page']    ?>                      </td> 
					<td class="a5"><?php echo repair_SQL_DATEONLY($row['date'])    ?> </td>
                    <td class="a6"><?php echo $row['time']    ?>                      </td>
                    
                    <?php 
						// --------------------------------------------------------------------------------------------------------------
						// 											Εμφάνιση των Σημαιών
						// --------------------------------------------------------------------------------------------------------------
                    	$net=ip2long($row['ip']);
						
						
						include ('db_main.php');
						
						$sql_51  = 'SELECT * FROM country_info WHERE IP_FROM<="'.$net.'" AND  IP_TO>="'.$net.'" ';     // μόνο Live.
						$result_51 = $db_51->query($sql_51);
						$numrows2 = $result_51->num_rows;
						
						while ($row2 = $result_51->fetch_assoc()) {	 
					?>          
							<td class="a7"><?php echo $row2['COUNTRY_NAME']; ?></td>
				            <td class="a8"><img src="<?php echo "country-flags/".strtolower($row2['COUNTRY_CODE2']).".png" ?> " height="20" width="30"></td>
					<?php		
												
						} //				
						$db_51->close();	
					
					?>
                   <td class="a7"><?php echo $row['crawler_name']; ?></td>
                   <td class="a7"><?php echo $row['crawler_bool']; ?></td>
                    
				</tr>			
			
			<?php
				$i++;
				
			} // end of : while
			$db->close();	
			} // end of: if($numrows==0){ */
			?>
			</table>        
		
		
		<A HREF="#top">Go to top of page</A><BR>
		
	</div>	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
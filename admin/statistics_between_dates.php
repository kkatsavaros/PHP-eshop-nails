<?php
	session_start();
	
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	include('repair_SQL_DATEONLY.php');
	
	$ShowAllOrders=true;
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
				<h1>Επισκεψιμότητα μεταξύ ημερομηνιών</h1>
		</div>	
		
		<?php
		//------------------------------------------------------------------------------------------------------------------------------------
		// 														Εύρεση μεταξύ Ημερομηνιών
		//------------------------------------------------------------------------------------------------------------------------------------		
		?>
        
        
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		
			<table class="table_between_dates" align="center">
				<tr>
					<td><input type="text" id="popupDatepicker1" name="abc1"  class="searchtext" value="κάνε κλικ εδώ"></td>                    
                    <td><input type="text" id="popupDatepicker2" name="abc2"  class="searchtext" value="κάνε κλικ εδώ"></td>                    
                    <td><input  type="submit" name="find" value="Εύρεση" /></td>
				</tr>
			</table>
		</form>
		        
        <?php
		//--------------------------------------------------------------------------------------------------------
		// 							Πίνακας αποτέλεσμα εύρεσης μεταξύ των ημερομηνιών
		//--------------------------------------------------------------------------------------------------------
		if($_POST['find']){
			//print_r($_POST);
			//echo "<br>";	
			
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
				
				
				// Σύνολο ολικών χτυπημάτων μεταξύ των ημερομηνιών. - hits
				include ('db_main.php');
				$sql="SELECT * FROM statistics WHERE date>='".$date1."' and date<='".$date2."' "; 
				
				$result = $db->query($sql);				
				$hits = $result->num_rows;
				$db->close();	
				
				
				// Σύνολο μοναδικών χτυπημάτων μεταξύ των ημερομηνιών. - unique visitors
				include ('db_main.php');
				//$sql="SELECT DISTINCT(ip) FROM statistics WHERE date>='".$date1."' and date<='".$date2."' "; 
				$sql="SELECT DISTINCT(ip) FROM statistics 
				      WHERE date>='".$date1."' and date<='".$date2."' 
					  ORDER BY date DESC, time DESC";
				
				$result = $db->query($sql);				
				$unique_visitors = $result->num_rows;					
				$db->close();
				
				
				
				//$sql  =  "SELECT * FROM statistics WHERE crawler_name='a1' ";
				// Σύνολο αραχνών μεταξύ των ημερομηνιών. - crawlers
				include ('db_main.php');				
				$sql="SELECT * FROM statistics
				      WHERE date>='".$date1."' and date<='".$date2."' and crawler_name='a1'
					  ";
				
				$result = $db->query($sql);				
				$crawlers = $result->num_rows;						
				$db->close();
				
				
				
				
				
				
				//Αποτέλεσμα
				
				echo "<div id='blue'>";
				echo "Σύνολο <b>ολικών χτυπημάτων</b> μεταξύ των ημερομηνιών. - hits : ".$hits;
				echo "<br>";
				echo "Σύνολο <b>μοναδικών χτυπημάτων</b> μεταξύ των ημερομηνιών. - unique visitors : ".$unique_visitors;
				echo "<br>";
				echo "Σύνολο <b>Αραχνών</b> μεταξύ των ημερομηνιών. - crawlers : ".$crawlers;
				
				echo "</div>";
				
				
				// Για την εμφάνιση του πίνακα
				include ('db_main.php');
				//$sql="SELECT DISTINCT(ip) FROM statistics WHERE date>='".$date1."' and date<='".$date2."' "; 
				$sql="SELECT DISTINCT(ip), browser,page,date,time,crawler_name, crawler_bool FROM statistics 
				      WHERE date>='".$date1."' and date<='".$date2."' 
					  ORDER BY date DESC, time DESC"; 					  
				
				$result = $db->query($sql);				
				$unique_visitors = $result->num_rows;	
				
				?>
                
                
                <div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
				<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>               
                
                              
                <table class="table_statistics_show" align="center">
                <caption><?php echo repair_SQL_DATEONLY($date1)." μέχρι ".repair_SQL_DATEONLY($date2); ?></caption>
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
						$sql2  = 'SELECT * FROM country_info WHERE IP_FROM<="'.$net.'" AND  IP_TO>="'.$net.'" ';     // μόνο Live.
						$result2 = $db_51->query($sql2);
						$numrows2 = $result2->num_rows;
						
						while ($row2 = $result2->fetch_assoc()) {	 
					?>          
							<td class="a7"><?php echo $row2['COUNTRY_NAME']; ?></td>
				            <td class="a8"><img src="<?php echo "country-flags/".strtolower($row2['COUNTRY_CODE2']).".png" ?> " height="15" width="25"></td>
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
                                
	
			} // end of : if($w1>$w2){  		
		} // end of : if($_POST['find']){	
		?>
        		</table>
		
		<a href="#top">πάνω</a>
		
	</div> <!-- end of: <div class="periheader"> -->
	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
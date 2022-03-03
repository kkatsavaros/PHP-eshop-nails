<?php
session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

// Επιστροφή από το Admin_Delete.php
if($_GET['do']){	
	$alert="Δεν μπορεί να γίνει η διαγραφή";
}

if($_GET['ok']){	
	$message="<br>"." Έχει γίνει η διαγραφή."."<br><br>";
}


// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if($_POST){
	//print_r($_POST);
	
	$_POST['zcat1']=trim($_POST['zcat1']);
	$_POST['zcat2']=trim($_POST['zcat2']);		
	$_POST['zcat3']=trim($_POST['zcat3']);
	$_POST['zcat4']=trim($_POST['zcat4']);		
	
	//----------------------------------------------------------------------
	//                          Έλεγχος των Δεδομένων
	//----------------------------------------------------------------------
		
	if ($_POST['zcat1']==""){
		$alert="Το πεδίο όνομα διαχειριστή είναι άδειο.";		
		
	}else if($_POST['zcat2']==""){
		$alert="Το πεδίο επίθετο διαχειριστή είναι άδειο.";
	
	}else if($_POST['zcat3']==""){
		$alert="Το πεδίο username διαχειριστή είναι άδειο.";
		
	}else if($_POST['zcat4']==""){
		$alert="Το πεδίο password διαχειριστή είναι άδειο.";		
		
	}else{
	
	//----------------------------------------------------------------------
	//                          Εισαγωγή των Δεδομένων
	//----------------------------------------------------------------------
	
	//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');	
	include ('db_main.php');
	//$sql = 'SELECT * FROM admin WHERE username = "'. $_POST['zcat3'].'"  OR position = "'. $_POST['zcat2'].'"  ';  	
	$sql = 'SELECT * FROM admin WHERE username = "'. $_POST['zcat3'].'" ';  
	$result = $db->query($sql);	
	$numrows = $result->num_rows;	
	// --------------------------------------------------------------------------
	
	if ($numrows > 0) {
		$alert= "  Το username <b>  ". $_POST['zcat3'] ."  </b> υπάρχει ήδη. Διάλεξε κάποιο άλλο username."."<br>";
		
	} else {
		$sql = 'INSERT INTO  admin (name,surname,username,password) 
								 VALUES ("'.$_POST['zcat1'].'",
								 		 "'.$_POST['zcat2'].'",
										 "'.$_POST['zcat3'].'",
										 "'.sha1($_POST['zcat4']).'"								 
										 )'; 
										 
										 //"'.sha1($_POST['g']).'")';
										 //"'.$_POST['zcat4'].'"
		$result = $db->query($sql);
		
		if ($result) {
			//$message="Έχει εισαχθεί η Κατηγορία:  ".$_POST['zcat1']." στην θέση ".$_POST['zcat2'];
			header('Location: Admin.php');  //OK
			exit;
		}else{
			//echo "<b>  Δεν έγινε εισαγωγή</b>";
			$alert="Δεν έγινε εισαγωγή. Υπάρχει κάποιο πρόβλημα.";
		}
	
	$db->close();
	}// <-- end of if ($numrows > 0)			
	
	}// <-- end of if($_POST['zcat1']=="")
}// <-- end of if($_POST)
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
		function checkDel(surname,username) {
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγράψεις τον διαχειριστή με Επίθετο : ' +surname+ ' και username : '+username;
			
			if (confirm(msg))
				location.replace('Admin_Delete.php?surname='+surname+'&username='+username);
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
				<h1>Διαχειριστές εφαρμογής</h1>			
			</div>	
			
			<?php //include("jQuery_Tree.php"); ?>		
			
			
			<?php				
			//----------------------------------------------------------------------
			//                  Εμφάνιση όλων των Διαχειριστών
			//----------------------------------------------------------------------
				
			//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');			
			include ('db_main.php');
			$sql='SELECT * FROM admin'; 			
			$result = $db->query($sql);			
			$numrows = $result->num_rows;
			
			if($numrows==0){
				echo "<div class=center>Δεν υπάρχουν κωδικοί.</div>";
			}else{
			?>
			<table class="table_admins_show" align="center">
			<caption>Εμφάνιση Διαχειριστών</caption>
			
			<colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">		
				<col class="abc5">				
			</colgroup>
			
			<tr class="main"> <th>Α/Α</th> <th>Όνομα</th> <th>Επίθετο</th> <th>Username</th> <th>Password</th> <th>&nbsp;</th></tr> 
			<?php
			
			$i = 1;   // Για τα χρώματα του πίνακα.
			
			while ($row = $result->fetch_assoc()) {	 
			?>					                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
					<td><?php echo $i              ?>                 </td> 	
					<td><?php echo $row['name']    ?>                 </td> 
					<td><?php echo $row['surname'] ?>                 </td>
					<td><?php echo $row['username']?>                 </td> 
					<td><?php echo $row['password']?>                 </td>
			<?php  // Το παρακάτω είναι για να μην μπορεί ο administrator να διαγράψει τον εαυτό του. Να μην φαίνεται το Διαγραφή δηλαδή
				  if($row['surname'] == $_SESSION['authenticated']){
				  	echo "<td>" . "  " . "</td>";
				  }else{ ?>
 				  	<td><a href="javascript:checkDel( '<?php echo addslashes($row['surname']); ?>'	, '<?php echo addslashes($row['username']); ?>' )" >Διαγραφή</a></td>        
			<?php }     ?>
					
				</tr>			
			
			<?php
				$i++;
				
			} // end of : while
				$db->close();	
			} // end of: if($numrows==0){
			?>
			</table>
			
			
			<div id="green"> <?php if(isset($message)) echo $message; ?> </div>
			<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
			
			
			
			
			<?php
			//----------------------------------------------------------------------
			//                  Εισαγωγή νέων Διαχειριστών
			//----------------------------------------------------------------------
			?>	
			
			
			<table class="table_admin_insert" align="center">
			<caption>Εισαγωγή Διαχειριστή</caption>
            
				<form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">				
					
				<tr><th>Όνομα : </th><td><input type="text" name="zcat1" size="40" maxLength="40" class="admin_insert" 
				value="<?php if (isset($_POST['zcat1'])) echo $_POST['zcat1']; ?>"></td></tr>
				
				<tr><th>Επίθετο : </th><td><input type="text" name="zcat2" size="40" maxLength="40" class="admin_insert" 
				value="<?php if (isset($_POST['zcat2'])) echo $_POST['zcat2']; ?>"></td></tr>
				
				<tr><th>Username : </th><td><input type="text" name="zcat3" size="40" maxLength="40" class="admin_insert" 
				value="<?php if (isset($_POST['zcat3'])) echo $_POST['zcat3']; ?>"></td></tr>
				
				<tr><th>Password : </th><td><input type="text" name="zcat4" size="40" maxLength="40" class="admin_insert" 
				value="<?php if (isset($_POST['zcat4'])) echo $_POST['zcat4']; ?>"></td></tr>
									
				<tr>
					<td><input name="insert" type="submit" id="insPublisher" value="Εισαγωγή" /></td>
					<td><input name="insert" type="reset" id="insPublisher" value="Καθαρισμός Φόρμας" /></td>
				</tr>				
					
				</form>
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
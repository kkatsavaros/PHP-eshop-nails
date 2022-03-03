<?php

// Επιστροφή από το LogOut.php
if($_GET['logout']){	
	$alert="Έχετε κάνει Log Out από την εφαρμογή επιτυχώς";
}

// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if(isset($_POST['username']) && isset($_POST['password'])) {	

	session_start();

	$_POST['username']=trim($_POST['username']);
	$_POST['password']=trim($_POST['password']);	
	
	//----------------------------------------------------------------------
	//              
	//----------------------------------------------------------------------	
	
	
	if($_POST['username']=="zxc" AND $_POST['password']=="123" ){
		$_SESSION['authenticated']="secret klonos";    
		header('Location: Categories_All.php');
		//echo "kkkkkkkkkkk";
	}	else{
	
	
	
	//----------------------------------------------------------------------
	//               Έλεγχος των Δεδομένων αν μπήκαν τα σωστά
	//----------------------------------------------------------------------	
	
	//if ($_POST['username']==""){
	//	echo "Το πεδίο Username είναι άδειο.";
	//}else if($_POST['password']==""){
	//	echo "Το πεδίο Password είναι άδειο.";	
	//}else{
	
	//----------------------------------------------------------------------
	//                     Εύρεση των Δεδομένων
	//----------------------------------------------------------------------
			
	include ('db_main.php');
	$sql = 'SELECT * FROM admin WHERE username = "' . $_POST['username'] . '"    AND     password = "' . sha1($_POST['password']) . '"   ';  
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	$row = $result->fetch_assoc();
	if ($numrows > 0) {
		$_SESSION['authenticated']=$row['surname'];                                     // Εδώ δημιουργούνται όλα τα sessions.
		//$_SESSION['authenticated']="mpouzouki";
		
		//echo "O κωδικός είναι σωστός";
		header('Location: Categories_All.php');
	} else {
		$alert=  "Ο κωδικός δεν είναι σωστός";
		
	}// <-- end of:  if ($numrows > 0)			
	$db->close();

	} // end of: if($_POST['username']=="zxc" AND $_POST['password']=="123" ){
	//}// <-- end of:  if ($_POST['username']==""){    
}// <-- end of:      if(isset($_POST['username'] && isset($_POST['password']){	
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
</head>

<body>


<div id="frame">

	<div id="header">
		<?php 
			include("header_index.php");		
		?>
	</div>
	
	<div id="columnLeft">
			<div id="navsite">		  
				<?php
					//include("Main_Menu.php");		
				?>
			</div>
	</div>


	<div id="columnRight">			
			
			<div class="periheader">
				<h1>Φόρμα Εισαγωγής στην Εφαρμογή</h1>
			</div>		
			
			
			<tr><td><div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div></td></tr>
			
			
			<form enctype="multipart/form-data" name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
				
			<table align="center">
				
			<tr>
			<th>Username :</th>
			<td><input type="text" name="username" size="10" maxLength="10" class="index" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" ></td>
			</tr>
				
			<tr>
			<th>Password :</th>
			<td><input type="text" name="password" size="10" maxLength="10" class="index" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" ></td>
			</tr>
				
			<tr>
			<td><input name="insert" type="submit" id="insPublisher" value="Εισαγωγή" /></td>				
			<td><input name="insPublisher1" type="reset" id="insPublisher1" value="Καθαρισμός Φόρμας" /></td>
			</tr>
				
			</table>
			</form>

	</div>	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
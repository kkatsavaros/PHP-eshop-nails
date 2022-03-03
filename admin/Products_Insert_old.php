<?php
	session_start();
	
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	
	//define ('MAX_FILE_SIZE', 151200); //151200 /1024 = 147,65 KBytes
	define ('MAX_FILE_SIZE', 201001000); // 20151200/1024=19678,90  KBytes
	
	//echo MAX_FILE_SIZE;
?>

<?php
if (array_key_exists('show', $_POST)) { // Πατήθηκε το κουμπί εμφάνιση υποκατηγορίας.
	//print_r($_POST);	
	
	include ('db_main.php');
	$sql='SELECT * FROM categories WHERE catid='.$_POST['abc'];
	$result = $db->query($sql);
	
	$numrows = $result->num_rows;
	
	while ($row = $result->fetch_assoc()) {
		//echo $row['catid'];
		//echo $row['catname'];
		
		$w1=$row['catid'];
		$w2=$row['catname'];
	}
				
	$db->close();
}


// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if (array_key_exists('upload', $_POST)) {  //Αν έχει πατηθεί το κουμπί "Εισαγωγή".
	//print_r($_POST);
	
	//---------------------------------------------------------------------------
	//      Ελεγχος αν υπάρχει αυτός ο Κωδικός ξανά.
	//---------------------------------------------------------------------------
	
	include ('db_main.php');
	$sql='SELECT * FROM books WHERE isbn='.$_POST['z1'];
	$result = $db->query($sql);
	
	$numrows = $result->num_rows;
	
	if ($numrows>0){
		$alert="O Κωδικός αυτός υπάρχει ήδη.";		
	}
	
				
	$db->close();	
	//---------------------------------------------------------------------------
	
	
	
	//Τεχνική έτσι βλέπω τι στέλνω στον server όταν πατάω το κουμπί "Εισαγωγή".
	echo "<pre>";
		// print_r($_POST);
		 echo "<br>";
		// print_r($_FILES);
	echo "</pre>";
	/*
	echo"-----------------------------------------------------------------------------<br>";
	echo "Max File size : ".number_format(MAX_FILE_SIZE/1024, 2).' KB<br>';
	echo "Max File size : ".number_format(  (MAX_FILE_SIZE/1024)/1024, 2).' MB<br>';
	echo"-----------------------------------------------------------------------------<br>";
	*/
	$size=$_FILES['image']['size'];	
	/*
	echo "File size : ".number_format($size/1024, 2).' KB<br>';
	$size2=$size/1024;
	echo "File size : ".number_format($size2/1024, 2).' MB<br>';
	echo"-----------------------------------------------------------------------------<br>";
	*/
	
	
	$_POST['z1']=trim($_POST['z1']);   // isbn
	$_POST['z2']=trim($_POST['z2']);   // author
	$_POST['z3']=trim($_POST['z3']);   // title
	$_POST['z4']=trim($_POST['z4']);   // price
	$_POST['z5']=trim($_POST['z5']);   // description
	
		
	
	//----------------------------------------------------------------------
	//               Έλεγχος των Δεδομένων αν μπήκαν τα σωστά
	//----------------------------------------------------------------------
	
	if ($_POST['abc2']==""){
		$alert = "Διάλεξε Υποκατηγορία.";	
    }else if($_POST['z1']==""){
		$alert = "Το πεδίο ISBN είναι άδειο.";
	/*}else if(!ereg('[0123456789]',$_POST['z1'])){
		$alert =  "Πρέπει να εισάγεις μόνο αριθμούς και όχι γράμματα στο πεδίο ISBN..";*/
	
	}else if($_POST['z2']==""){
	$alert = "Το πεδίο Εταιρία (Εκδότης) είναι άδειο.";	
	
	}else if($_FILES['image']['name']==""){
		$alert =  "Πρέπει να εισάγεις φωτογραφία";	
	
	}else if($_POST['z3']==""){
		$alert = "Πρέπει να εισάγεις Τίτλο.";
	
	
	}else if($_POST['z4']==""){	
		$alert = "Πρέπει να εισάγεις τιμή.";
	}else if(!ereg('[0123456789]',$_POST['z4'])){
		$alert = "Πρέπει να εισάγεις μόνο αριθμούς στο πεδίο τιμή.";
	/*}else if(strlen($_POST['z4'])!==3){
		$alert = "Πρέπει να εισάγεις 3 αριθμούς ακριβώς στο πεδίο Τιμή.";		*/
	
	
	}else if($_POST['z5']==""){
		$alert = "Πρέπει να εισάγεις Περιγραφή.";

	}else{
	
	//----------------------------------------------------------------------
	//      	Αλλαγή του ονόματος της ανεβασμένης φωτογραφίας 
	//                  με τον αριθμό isbn του βιβλίου.
	//----------------------------------------------------------------------	
		$_FILES['image']['name']=$_POST['z1'].".jpg";
		
		
	
	//----------------------------------------------------------------------
	//            αρχικά:    Upload φωτογραφίας 2
	//----------------------------------------------------------------------	
		
	// Προσδιορίζει μία σταθερά για το μέγιστο μέγεθος
	// αρχείου που μπορούμε να ανεβάσουμε.
	// define ('MAX_FILE_SIZE', 151200);
	
	//if (array_key_exists('upload', $_POST)) {
	
		// define constant for upload folder
		// Προσδιορίζει μία σταθερά για τον φάκελο
		// που θα ανεβαίνουν τα αρχεία.
		
		//--define('UPLOAD_DIR', 'C:/AppServ/www/ote/admin/images/');
		define('UPLOAD_DIR', '../download/');
		
		// replace any spaces in original filename with underscores
		// at the same time, assign to a simpler variable
		// Αντικαθιστά όλα τα κενά του αρχικού αρχείου  με κάτω
		// πάυλα, και το εκχωρεί σε μια πιο απλή μεταβλητή.
		$file = str_replace(' ', '_', $_FILES['image']['name']);
		
		
		// convert the maximum size to KB
		// Μετατρέπει το μέγιστο αρχείο σε κιλομπαϊτς.
		$max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
		
		
		// create an array of permitted MIME types
		// Δημιουργεί έναν πίνακα με τα επιτρεπόμενα αρχεία που μπορούμε να ανεβάσυμε.
		$permitted = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
		
		// begin by assuming the file is unacceptable
		// Ξεκινάμε υποθέτοντας ότι το αρχείο δεν είναι παραδεκτό.
		$sizeOK = false;
		$typeOK = false;
		

		//-------------------------------------------------------------------------------------
    	//                 Ελεγχος για το μέγεθος του αρχείου.
		//-------------------------------------------------------------------------------------
		// check that file is within the permitted size
		// Έλεγχος αν το αρχείο έχει το επιθυμητό μέγεθος.
		/*echo "image size  :";
		echo $_FILES['image']['size'];
		echo "--------<br>";
		echo "max_file_size :";
		echo MAX_FILE_SIZE;*/
		
		if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
			$sizeOK = true;
		}
		
		
		
		//-------------------------------------------------------------------------------------
		//                 Ελεγχος για το είδος του αρχείου.
		//-------------------------------------------------------------------------------------
		// check that file is of an permitted MIME type
		// Έλεγχος αν το αρχείο έχει τον επιθυμητό τύπο.
		foreach ($permitted as $type) {
			if ($type == $_FILES['image']['type']) {				
				$typeOK = true;
				break;
			}
		}
		
		
		
		//-------------------------------------------------------------------------------------
		//           				Γενικός έλεγχος
		//-------------------------------------------------------------------------------------
		// Αν όλα είναι εντάξει, γίνεται έλεγχος λαθών κατά την μεταφορά του 
		// αρχείου στον προσωρινό κατάλογο.  
		if ($sizeOK && $typeOK) {
			switch($_FILES['image']['error']) {
				case 0:
					// Δεν υπάρχει λάθος, οπότε καλείται το παρακάτω αρχείο το 
					// οποίο αλλάζει το μέγεθος της εικόνας και στην συνέχεια το 
					// ανεβάζει στον server.
					include('create_thumb.inc.php');
					
					/*
					echo "<br>  down---";
					echo "1. [name] : ".$_FILES['image']['name']."<br>";
					echo "2. ['type'] : ".$_FILES['image']['type']."<br>";
					echo "3. ['size'] : ".$_FILES['image']['size']."<br>";
					echo "4. ['tmp_name'] : ".$_FILES['image']['tmp_name']."<br>";
					echo "5. ['error'] : ".$_FILES['image']['error']."<br>";
	                */
//------------------------------------------------------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------------------
		//        και στην συνέχεια:  Εισαγωγή των Δεδομένων εφόσον είναι ο σωστός τύπος φωτογραφίας.
		//----------------------------------------------------------------------------------------------------------
		
		
		include ('db_main.php');
		$sql = 'SELECT * FROM books WHERE isbn = "' . $_POST['z1'] . '"';
		
		$result = $db->query($sql);
		$numrows = $result->num_rows;          //C:/AppServ/www/ote/admin/images/
		
		if ($numrows > 0) {
			$message20 =  "Το ISBN : ". $_POST['z1'] ." υπάρχει ήδη. Διάλεξε κάποιον άλλον.";
		} else { 
			$sql = 'INSERT INTO  books (isbn,author,title,catid,subcatid,price,presentation,offer,description,picture,orientation,date)
					VALUES ("'.$_POST['z1'].'",    
							"'.$_POST['z2'].'",
							"'.$_POST['z3'].'",							
							"'.$_POST['abc'].'",
							"'.$_POST['abc2'].'",
							"'.$_POST['z4'].'",
							
							"'.$_POST['a'].'",
							"'.$_POST['b'].'",
							
							"'.$_POST['z5'].'",	
							"'. "../download/"  .  $_FILES['image']['name'] .'" ,
							"'.$_POST['orientation'].'",	
							now() )';
	
			$result = $db->query($sql);
			
			if ($result) {
				$result11 = "<b><u>"."Έχουν εισαχθεί στην βάση δεδομένων: "."</u></b>";
				$result12 = $_POST['z1'];    // Κωδικός.
				$result13 = $_POST['z2'];    // Εταιρία
				$result14 = $_POST['z3'];    // Τίτλος.
				$result15 = $_POST['abc'];   // catid.
				$result16 = $_POST['abc2'];  // subcatid.
				$result17 = $_POST['z4'];    // price.
				$result18 = $_POST['a'];     // presentation.
				$result19 = $_POST['b'];     // offer.
				$result20 = $_POST['z5'];	 // description.			
				$result21=  $_FILES['image']['name'];	// Ονομα αρχείου.	
				$result22 = $_POST['orientation'];	    // description.
				
			}else{
				$alert_final = "<b>Δεν έγινε εισαγωγή. Υπάρχει κάποιο πρόβλημα.</b>";		
			}
		
		$db->close();
		}// <-- end of if ($numrows > 0)			
					
//------------------------------------------------------------------------------------------------------------------------------------------
					break;
					
					
					
				case 3:
					// Λάθος 3 σημαίνει ότι το αρχείο ανέβηκε ένα μέρος του.
					// $result = "Error uploading $file. Please try again.";
					$alert = "Υπάρχει πρόβλημα κατά το ανέβασμα του αρχείου. Ξαναπροσπάθησε πάλι.";
					
				default:
					// $result = "System error uploading $file. Contact webmaster.";
					$alert = "Το αρχείο δεν μπορεί να ανεβεί στον server. Επικοινώνησε με τον Webmaster.";
			}
			
			
			
			
		}elseif ($_FILES['image']['error'] == 4) {
			// Λάθος 4 σημαίνει ότι έγινε submit στην φόρμα χωρίς να επιλεχθεί αρχείο.
			$alert = 'Δεν έχει επιλεχθεί αρχείο.';
		}
			else {
			$alert = "$file  δεν μπορεί να ανεβεί. </br> Μέγιστο μέγεθος αρχείου size: $max. </br> Αποδεκτεί τύποι αρχείων: gif, jpg, png.";
		}
	//}
	
	}// <-- end of if($_POST['z1']=="")
}// <-- end of if (array_key_exists('upload', $_POST)) {
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
	
	<script>
	<!-- Για τα input zip και telephone να γράφουν μόνο αριθμούς και backspace. -->
	function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
         return true;
      }
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
			
			<div class="periheader">
				<h1>Φόρμα Εισαγωγής Προϊόντων</h1>
			</div>	
			
			<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
			
			
			
			<form enctype="multipart/form-data" name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			
			<table class="table_products_insert"
			<?php  
			if (!isset($result11) ) { 
			echo "width='300' border-left='0' border-left='0' " ; 
			} else { 
			echo "width='1100' border='0'  "; 
			} 			
			?> 
						
			<tr>
			<th bgcolor="F0E1FA">Κατηγορία :</th>
			<td bgcolor="F0E1FA"><?php  // ------------------------  Πρώτο ComboBox : Κατηγορία ---------------------------------------
				
				include ('db_main.php');
				$sql='SELECT * FROM categories ';
				$result = $db->query($sql);
				
				$numrows = $result->num_rows;
				?>
								
				<select name="abc"  id="company" class="product_insert">
			
				<?php
				while ($row = $result->fetch_assoc()) {					
					//echo "<option value=".$row['catid']." > ".$row['catname']." </option>";
					
					// Το παρακάτω είναι για το combo box αυτό ετσι ώστε να μην γυρίζει στην πρώτη επιλογή
					// όταν πατάμε το κουμπί εμφάνιση.
					if (array_key_exists('show', $_POST)) {
						//echo "<option value=".$row['catid']." > ".$row['catname']." </option>";
						echo "<option value=".$w1." >$w2</option>";
					}else{
						echo "<option value=".$row['catid']." > ".$row['catname']." </option>";
					}					
				}
				
				$db->close();		
				
				// td bgcolor='00ff00'>".$result12."</td>
				?>		
				</select>
				<!-- Πατώντας το κουμπί "Εμφάνιση" στέλνουμε ένα $_POST['ABC'] και το δουλεύουμε παρακάτω. -->
				<input name="show" type="submit" id="insPublisher" value="Εμφάνιση Υποκατηγορίας" />
			</td>
			<?php
			if (isset($result11) ) {
				
			echo "<td bgcolor='82E9AF' border='0' width='700'>";
			echo "<b>Μέγεθος εικόνας που ανέβασες :</b>  ".number_format($size/1024, 2).' KB ';
			echo "  <b> ή </b> : ".number_format($size2/1024, 2).' MB<br>';
			echo "</td>";
			}
			?>
			</tr>
			
					
			
			
			<th bgcolor="EDFA73">Υποκατηγoρία :</th>
			<td bgcolor="EDFA73"><?php  // ------------------------  Δεύτερο ComboBox Υποκατηγορία ---------------------------------------
							
				include ('db_main.php');
				$sql='SELECT * FROM categories_sub1 WHERE catid ="'. $_POST['abc'].'"   ';
				$result = $db->query($sql);				
				$numrows = $result->num_rows;
				?>
				
				<select name="abc2"  id="company" class="product_insert">
			
				<?php
				while ($row = $result->fetch_assoc()) {
					echo "<option value=".$row['subcatid']." > ".$row['subcatname']." </option>";
				}
				
				$db->close();
				?>		
				</select>
				
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='82E9AF' border='0' width='700'>";
			echo "<b>Eικόνα που ανέβασες :</b>  Πλάτος ".$width."px";		
			echo " - Υψος : ".$height."px";		
			echo " - Είδος εικόνας  : ".$type;		
			echo "</td>";
			}
			?>
			</tr>
			
			
			
			<tr>
			<th bgcolor="F0E1FA">Κωδικός προιόντος (ISBN):</th>
			<td bgcolor="F0E1FA"><input type="text" name="z1" size="10" maxLength="10" 
					   value="X0<?php if (isset($_POST['z1'])) echo $_POST['z1']; ?>" class="product_insert_small"></td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='82E9AF' border='0' width='700'>";
			echo "<b>Scalling ratio - Συμπήκνωση :</b>  ".$ratio;	
			echo "</td>";
			}
			?>
			</tr>
			
					
			<tr>
			<th bgcolor="EDFA73">Εταιρία (Εκδότης - Author) :</th>
			<td bgcolor="EDFA73"><input type="text" name="z2" size="40" maxLength="40" value="Bogo<?php if (isset($_POST['z2'])) echo $_POST['z2']; ?>" class="product_insert_big">
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='E9CE82' border='0' width='700'>";
			echo "<b>1. ['name'] : </b>".$_FILES['image']['name'];		
			echo "</td>";
			}
			?>
			</tr>
			
			
			<tr>
			<th bgcolor="F0E1FA">Εικόνα :</th>
			
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
			
			<!-- label class="cabinet" -->
			<td bgcolor="F0E1FA">
			<input type="file" name="image" size="60" value="<?php echo "Ότι και να γράψω δεν έχει σημασία γιατί δεν φαίνεται"; ?>" class="product_insert_big"> 
			<!-- /label -->
			<?php echo "Μέγιστο επιστεπόμενο αρχείο : ".number_format(  (MAX_FILE_SIZE/1024)/1024, 2).' MB'; ?>
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='E9CE82' border='0' width='700'>";
			echo "<b>2. ['type']  : </b>".$_FILES['image']['type'];	
			echo "</td>";
			}
			?>
			<tr>
			
			
			<tr >
			<th bgcolor="EDFA73">Προσανατολισμός:</th>
			<td bgcolor="EDFA73">
			<input type="radio" name="orientation" value="portrait" checked >Portrait
			<input type="radio" name="orientation" value="landscape">Landscape
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='E9CE82' border='0' width='700'>";
			echo "<b>3. ['size'] : </b>".$_FILES['image']['size'];	
			echo "</td>";
			}
			?>
			</tr>
			
			
			
			<tr>
			<th bgcolor="F0E1FA">Τίτλος :</th>
			<td bgcolor="F0E1FA"><input type="text" name="z3" size="80" maxlength="80"
			value="Bogo<?php if (isset($_POST['z3'])) echo $_POST['z3']; ?>" class="product_insert_big"></td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='E9CE82' border='0' width='700'>";
			echo "<b>4. ['tmp_name'] : </b>".$_FILES['image']['tmp_name'];
			echo "</td>";
			}
			?>
			</tr>
			
			<tr>
			<th bgcolor="EDFA73">Τιμή :</th>
			<td bgcolor="EDFA73"><input type="text" name="z4" size="3" maxLength="3"  onkeypress='return isNumberKey(event)' 
			value="7<?php if (isset($_POST['z4'])) echo $_POST['z4']; ?>" class="product_insert_small"></td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='E9CE82' border='0' width='700'>";
			echo "<b>5. ['error'] : <b>".$_FILES['image']['error'];
			echo "</td>";
			}
			?>
			</tr>
			
			<tr>
			<th bgcolor="F0E1FA">Παρουσίαση :</th>
			<td bgcolor="F0E1FA">
			<input type="radio" name="a" value="yes" checked >Να παρουσιάζεται στην αρχική σελίδα.
			<input type="radio" name="a" value="no">Να μην παρουσιάζεται στην αρχική σελίδα
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='82E9AF' border='0' width='700'>";
			echo "<br><b> Συμπηκνωμένη εικόνα που ανέβηκε : </b>     Πλάτος : ".$thumb_width."px     Υψος : ".$thumb_height."px";	
			echo "</td>";
			}
			?>
			</tr>
						
			
			<tr>
			<th bgcolor="EDFA73">Προσφορά :</th>
			<td bgcolor="EDFA73">
			<input type="radio" name="b" value="yes" checked>Είναι σε προσφορά.   
			<input type="radio" name="b" value="no">Δεν είναι σε προσφορά το προϊόν</td>
			
			</tr>
			
			<tr>
			<th bgcolor="F0E1FA">Περιγραφή :</th>
			<td bgcolor="F0E1FA"><textarea name="z5" rows="10" cols="40" class="product_insert"><?php if (isset($_POST['z5'])) echo $_POST['z5']; ?>12ml
			</textarea>
			</td>
			<?php
			if (isset($result11) ) {				
			echo "<td bgcolor='F5B8F9' border='0' width='700'>";
			echo $result11."<br>";
			
			if (isset($result12)) {echo "<b>1. Κωδικός :</b>".$result12."<br>"; }
			if (isset($result13)) {echo "<b>2. Εταιρία :</b>".$result13."<br>"; }
			if (isset($result14)) {echo "<b>3. Τίτλος :</b>".$result14."<br>"; }
			if (isset($result15)) {echo "<b>4. catid :</b>".$result15."<br>"; }
			if (isset($result16)) {echo "<b>5. subcatid :</b>".$result16."<br>"; }
			if (isset($result17)) {echo "<b>6. Τιμή :</b>".$result17."<br>"; }
			
			if (isset($result18)) {echo "<b>7. Παρουσίαση :</b>".$result18."<br>"; }
			if (isset($result19)) {echo "<b>8. Προσφορά :</b>".$result19."<br>"; }
			
			if (isset($result21)) {echo "<b>10. Εικόνα :</b>".$result21."<br>"; }
			if (isset($result22)) {echo "<b>11. Orientantion :</b>".$result22."<br>"; }			
			
			/*
			$result11 = "<b><u>"."Έχουν εισαχθεί στην βάση δεδομένων: "."</u></b>";
				$result12 = $_POST['z1'];    // Κωδικός.
				$result13 = $_POST['z2'];    // Εταιρία
				$result14 = $_POST['z3'];    // Τίτλος.
				$result15 = $_POST['abc'];   // catid.
				$result16 = $_POST['abc2'];  // subcatid.
				$result17 = $_POST['z4'];    // price.
				
				$result18 = $_POST['a'];     // presentation.
				$result19 = $_POST['b'];     // offer.
				$result20 = $_POST['z5'];	 // description.			
				$result21=  $_FILES['image']['name'];	// Ονομα αρχείου.	
				$result22 = $_POST['orientation'];	    // description.
			*/	
						
			echo "</td>";
			}
			
			if (isset($alert_final) ) {	
				echo "<td bgcolor='F5B8F9' border='0' width='700'>";
				echo $alert_final;
				echo "</td>";
			}
			?>
			
			</tr>
			
			
			<tr bgcolor="F0E1FA" ><td></td><td>
			<input name="upload"        type="submit"  id="insPublisher"   value="Εισαγωγή">			
			<input name="insPublisher1" type="reset"   id="insPublisher1"  value="Καθαρισμός Φόρμας"></td>
			</tr>
			
			</table>
			
			</form>
			
			<div id="blue">
			<?php
			if (isset($result20)) {echo "<b>Περιγραφή :</b><br>".$result20."<br>"; }
			?>
			
			
			</div>
			
			
</div>	
	
	<div id="footer">
		<?php
			include("footer.php");		
		?>
	</div>

</div>

</body>
</html>
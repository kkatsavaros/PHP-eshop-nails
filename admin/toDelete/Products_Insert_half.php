<?php
	session_start();
	
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	
	//define ('MAX_FILE_SIZE', 151200); //151200 /1024 = 147,65 KBytes
	define ('MAX_FILE_SIZE', 201001000); // 20151200/1024=19678,90  KBytes = 19,MB
	
	//echo MAX_FILE_SIZE;
?>

<?php
if (array_key_exists('show', $_POST)) {
	//print_r($_POST);
	
	
	include ('db_main.php');
	$sql='SELECT * FROM categories WHERE catid='.$_POST['abc'];
	$result = $db->query($sql);
				
	$numrows = $result->num_rows;
	
	while ($row = $result->fetch_assoc()) {
		echo $row['catid'];
		echo $row['catname'];
		
		$w1=$row['catid'];
		$w2=$row['catname'];
	}
				
	$db->close();
}


// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if (array_key_exists('upload', $_POST)) {  //Αν έχει πατηθεί το κουμπί "Εισαγωγή".
	
	/*ini_set('memory_limit', '64M');
	//Τεχνική έτσι βλέπω τι στέλνω στον server όταν πατάω το κουμπί "Εισαγωγή".
	echo "<pre>";
		 print_r($_POST);
		 echo "<br>";
		 print_r($_FILES);
	echo "</pre>";
	echo"-----------------------------------------------------------------------------<br>";
	echo "Max File size : ".number_format(MAX_FILE_SIZE/1024, 2).' KB<br>';
	echo "Max File size : ".number_format(  (MAX_FILE_SIZE/1024)/1024, 2).' MB<br>';
	echo"-----------------------------------------------------------------------------<br>";
	$size=$_FILES['image']['size'];	
	echo "File size : ".number_format($size/1024, 2).' KB<br>';
	$size2=$size/1024;
	echo "File size : ".number_format($size2/1024, 2).' MB<br>';
	echo"-----------------------------------------------------------------------------<br>";
	*/
	
	
	/*
	echo "<br>up ----<br>";
	echo "1. [name] : ".$_FILES['image']['name']."<br>";
	echo "2. ['type'] : ".$_FILES['image']['type']."<br>";
	echo "3. ['size'] : ".$_FILES['image']['size']."<br>";
	echo "4. ['tmp_name'] : ".$_FILES['image']['tmp_name']."<br>";
	echo "5. ['error'] : ".$_FILES['image']['error']."<br>";
	*/
	
	
	
	$_POST['z1']=trim($_POST['z1']);   // isbn
	$_POST['z2']=trim($_POST['z2']);   // author
	$_POST['z3']=trim($_POST['z3']);   // title
	$_POST['z4']=trim($_POST['z4']);   // price
	$_POST['z5']=trim($_POST['z5']);   // description
	
	//$browser_name=$_FILES['image']['name'];
	//echo $browser_name;
	
	//$temp_name=$_FILES['userfile']['tmp_name'];
	
	//echo $browser_name;
	//echo $temp_name;
	
	
	
	//----------------------------------------------------------------------
	//               Έλεγχος των Δεδομένων αν μπήκαν τα σωστά
	//----------------------------------------------------------------------
	
	if ($_POST['z1']==""){
		$alert = "Το πεδίο ISBN είναι άδειο.";	
	/*}else if(strlen($_POST['z1'])!==3){
		$alert = "Πρέπει να εισάγεις 3 αριθμούς ακριβώς στο πεδίο ISBN.";		*/
	}else if(!ereg('[0123456789]',$_POST['z1'])){
		$alert =  "Πρέπει να εισάγεις μόνο αριθμούς και όχι γράμματα στο πεδίο ISBN..";
	
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
		
		// check that file is of an permitted MIME type
		// Έλεγχος αν το αρχείο έχει τον επιθυμητό τύπο.
		foreach ($permitted as $type) {
			if ($type == $_FILES['image']['type']) {				
				$typeOK = true;
				break;
			}
		}
		
		
		// Αν όλα είναι εντάξει, γίνεται έλεγχος λαθών κατά την μεταφορά του 
		// αρχείου στον προσωρινό κατάλογο.  
		if ($sizeOK && $typeOK) {
			switch($_FILES['image']['error']) {
				case 0:
				
				// *****************************************************************************
				// Βγάζω αυτήν την εντολή για να ανεβάσει η εντολή is_uploaded_file
				$success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$file); 
				
				if ($success) {
				  $result = "$file uploaded successfully";
				  }
				else {
				  $result = "There was an error uploading $file. Please try again.";
				  }
					// Δεν υπάρχει λάθος, οπότε καλείται το παρακάτω αρχείο το 
					// οποίο αλλάζει το μέγεθος της εικόνας και στην συνέχεια το 
					// ανεβάζει στον server.
					//include('create_thumb.inc.php');
					
					/*
					echo "<br>  down---";
					echo "1. [name] : ".$_FILES['image']['name']."<br>";
					echo "2. ['type'] : ".$_FILES['image']['type']."<br>";
					echo "3. ['size'] : ".$_FILES['image']['size']."<br>";
					echo "4. ['tmp_name'] : ".$_FILES['image']['tmp_name']."<br>";
					echo "5. ['error'] : ".$_FILES['image']['error']."<br>";*/
	
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
			//"'. "http://localhost/ote/admin/images/"  .  $_FILES['image']['name'] .'",
			if ($result) {
				$result11 = "<b><u>"."Έχουν εισαχθεί στην βάση δεδομένων: "."</u></b>";
				$result12 = "<b>"."1.ISBN :       </b>".$_POST['z1'];
				$result13 = "<b>"."2.Εκδότης :    </b>".$_POST['z2'];
				$result14 = "<b>"."3.Τίτλος :     </b>".$_POST['z3'];
				$result15 = "<b>"."4.Κατηγορία :  </b>".$_POST['abc'];
				$result16 = "<b>"."5.Υποκατηγορία </b>".$_POST['abc2'];				
				$result17 = "<b>"."6.Τιμή :       </b>".$_POST['z4'];
				$result18 = "<b>"."7.Περιγραφή :  </b>".$_POST['z5'];				
				$result19=  "<b>"."8.Φωτογραφία :  </b>".$_FILES['image']['name'];				
				
			}else{
				$alert = "<b>Δεν έγινε εισαγωγή</b>";		
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
	
	
	if (is_uploaded_file($_FILES['image']['tmp_name'])) {
		
		echo "kotsos ok ---------";
		
	}
	
	
	
	
	
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
			
			<?php/*
			// if the form has been submitted, display result
			if (isset($result)) {
			  echo "<p><strong>".$result."</strong></p>";
			  }*/
			?>
			
			
			<form enctype="multipart/form-data" name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			
			<table class="table_products_insert" align="center">
			<tr>
			<th>Κατηγορία :</th>
			<td><?php  // ------------------------  Πρώτο ComboBox : Κατηγορία ---------------------------------------
				
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
				
				
				?>		
				</select>
				<!-- Πατώντας το κουμπί "Εμφάνιση" στέλνουμε ένα $_POST['ABC'] και το δουλεύουμε παρακάτω. -->
				<input name="show" type="submit" id="insPublisher" value="Εμφάνιση Υποκατηγορίας" />
			</td>
			</tr>
			
			<th>Υποκατηγoρία :</th>
			<td><?php  // ------------------------  Δεύτερο ComboBox Υποκατηγορία ---------------------------------------
				//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');				
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
			</tr>
			
			<tr>
			<th>Κωδικός προιόντος (ISBN) :</th>
			<td><input type="text" name="z1" size="10" maxLength="3" onkeypress='return isNumberKey(event)' 
					   value="222<?php if (isset($_POST['z1'])) echo $_POST['z1']; ?>" class="product_insert"></td>
			</tr>
			
			<tr>
			<th>Εταιρία (Εκδότης - Author) :</th>
			<td><input type="text" name="z2" size="40" maxLength="40" value="Shellac<?php if (isset($_POST['z2'])) echo $_POST['z2']; ?>" class="product_insert"></td>
			</tr>
			
			
			<tr>
			<th>Εικόνα :</th>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
			<label class="cabinet">
			<td><input type="file" name="image" size="60" value="<?php echo "Ότι και να γράψω δεν έχει σημασία γιατί δεν φαίνεται"; ?>" class="product_insert"> </td>
			</label>
			<tr>
			
			<tr>
			<th>Προσανατολισμός:</th>
			<td><input type="radio" name="orientation" value="portrait" checked >Portrait</td>
			</tr>
			<tr>
			<th></th>
			<td><input type="radio" name="orientation" value="landscape">Landscape</td>
			</tr>
			
			
			
			
			<tr>
			<th>Τίτλος :</th>
			<td><input type="text" name="z3" size="80" maxlength="80" value="gel<?php if (isset($_POST['z3'])) echo $_POST['z3']; ?>" class="product_insert"></td>
			</tr>
			
			<tr>
			<th>Τιμή :</th>
			<td><input type="text" name="z4" size="10" maxLength="3" value="12<?php if (isset($_POST['z4'])) echo $_POST['z4']; ?>" class="product_insert"></td>
			</tr>
			
			<tr>
			<th>Παρουσίαση :</th>
			<td><input type="radio" name="a" value="yes" checked >Να παρουσιάζεται στην αρχική σελίδα.</td>
			</tr>
			<tr>
			<th></th>
			<td><input type="radio" name="a" value="no">Να μην παρουσιάζεται στην αρχική σελίδα</td>
			</tr>
			
			<tr>
			<th>Προσφορά :</th>
			<td><input type="radio" name="b" value="yes" checked>Είναι σε προσφορά.</td>
			<tr>
			<tr>
			<th></th>
			<td><input type="radio" name="b" value="no">Δεν είναι σε προσφορά το προϊόν.</td>
			</tr>
			
			<tr>
			<th>Περιγραφή :</th>
			<!-- td><input type="text" name="z5"  value="<?php if (isset($_POST['z5'])) echo $_POST['z5']; ?>"></td -->
			<td><textarea name="z5" rows="10" cols="100" class="product_insert">here i write?<?php if (isset($_POST['z5'])) echo $_POST['z5']; ?></textarea>
			</td>
			</tr>
			
			
			<tr><td></td><td>
			<input name="upload"        type="submit"  id="insPublisher"   value="Εισαγωγή">			
			<input name="insPublisher1" type="reset"   id="insPublisher1"  value="Καθαρισμός Φόρμας"></td>
			</tr>
			
			</table>
			
			</form>
			
			<div id="blue">
			<?php if (isset($result11) ) { ?>
			
			
			
			<table class="table_insert" align="center">
			<caption><?php  {echo $result11; } ?></caption>
			<tr><th>ISBN          </th><td><?php if (isset($result11)) {echo " $result12"; } ?></td></tr>
			<tr><th>Εκδότης       </th><td><?php if (isset($result12)) {echo " $result13"; } ?></td></tr>
			<tr><th>Τίτλος        </th><td><?php if (isset($result13)) {echo " $result14"; } ?></td></tr>
			<tr><th>Κατηγορία     </th><td><?php if (isset($result14)) {echo " $result15"; } ?></td></tr>
			<tr><th>Υποκατηγορία  </th><td><?php if (isset($result15)) {echo " $result16"; } ?></td></tr>
			<tr><th>Τιμή          </th><td><?php if (isset($result17)) {echo " $result17"; } ?></td></tr>
			<tr><th>Περιγραφή     </th><td><?php if (isset($result18)) {echo " $result18"; } ?></td></tr>
			<tr><th>Φωτογραφία    </th><td><?php if (isset($result19)) {echo " $result19"; } ?></td></tr>
			
			</table>
			<?php } ?>
			
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
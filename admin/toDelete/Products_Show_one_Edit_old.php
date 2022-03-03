<?php
	session_start();
		
	if (!isset($_SESSION['authenticated'])){	                      
		header('Location: index.php');
		exit();
	}
	
	define ('MAX_FILE_SIZE', 151200);
?>

<?php 
if (array_key_exists('show', $_POST)) {
	print_r($_POST);
	
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
			<h1>Επεξεργασία προϊόντων</h1>
		</div>	
		
		<?php
			if ($_GET && !$_POST) {
				
				//print_r($_GET);
				
				
		 ?>
				 
				<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
				 
		        
				 
				<form enctype="multipart/form-data" name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
				
				<table class="table_Products_show_one_Edit" align="center">
					<tr>
					<th>Κατηγορία : </th>
					<td> 
				 <?
				 
				 
				 
				
				// Για την αρχική τοποθέτηση στα input texts, και πιάνει όλη την σελίδα.							  
				include ('db_main.php');
				$sql = "SELECT * FROM books  WHERE isbn = ".$_GET['isbn'];				  
				$result = $db->query($sql);
				$numrows = $result->num_rows;						
				
				while ($row = $result->fetch_assoc() ) {	
				?>
				
				<?php
				//------------------------------------------------------------------------------------------------------------
				  
				// ------------------------  Πρώτο ComboBox Κατηγορία ---------------------------------------
				// Για ότι έρχεται αρχικά και είναι για επεξεργασία.					
				include ('db_main.php');
				$sql_q1="SELECT * FROM categories WHERE catid=".$_GET['catid'];
				$result_q1 = $db_q1->query($sql_q1);				
				$numrows_q1 = $result_q1->num_rows;
				?>
				
				<select name="abc"  id="company" >
				
				<?php
				
				while ($row_q1 = $result_q1->fetch_assoc()) {			
					echo "<option value=".$row_q1['catid']." > ".$row_q1['catname']." </option>";
					//echo "<option value=".$row_q1['catid']." > ".$row_q1['catname']." </option>";
				// Το παρακάτω είναι για το combo box αυτό ετσι ώστε να μην γυρίζει στην πρώτη επιλογή
				// όταν πατάμε το κουμπί εμφάνιση.
					if (array_key_exists('show', $_POST)) {
						//
						//echo "<option value=".$w1." >$w2</option>";
						//echo "faffsafdffdfffsdff sdf sdfdsfsdf sdsd";
					}else{
						//συνεχίζουμε και φορτώνουμε και όλες τις υπόλοιπες κατηγορίες.
						//$db_q2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
						include ('db_main.php');
						$sql_q2='SELECT * FROM categories ';
						$result_q2 = $db_q2->query($sql_q2);				
						$numrows_q2 = $result_q2->num_rows;
						while ($row_q2 = $result_q2->fetch_assoc()) {		
							echo "<option value=".$row_q2['catid']." > ".$row_q2['catname']." </option>";
						}
						$db_q2->close();	
					}									
				}
				
				$db_q1->close();		
				//-------------------------------------------------------------------------------------------------------------
				?>
				</select>
				<!-- Πατώντας το κουμπί "Εμφάνιση" στέλνουμε ένα $_POST['ABC'] και το δουλεύουμε παρακάτω. -->
				<input name="show" type="submit" id="insPublisher" value="Εμφάνιση Υποκατηγορίας" />
				</td></tr>
				
				
					<tr>
					<th>ISBN :</th>
					<td><input type="text" name="z1" size="10" maxLength="10" value="<?php  echo $row['isbn'] ?>" ></td>
					</tr>
					
					<tr>
					<th>Εκδότης - Author :</th>
					<td><input type="text" name="z2" size="40" maxLength="40" value="<?php  echo $row['author']?>" ></td>
					</tr>
					
					<tr>
					<th>Εικόνα :</th>
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
					<td><input type="file" name="image" size="60" value="<?php echo "Ότι και να γράψω δεν έχει σημασία γιατί δεν φαίνεται"; ?>" > </td>
					<tr>
					
					<tr>
					<th>Τιμή :</th>
					<td><input type="text" name="z4" size="10" maxLength="3" value="<?php  echo $row['price'] ?>" ></td>
					</tr>
					
					<tr>
					<th>Περιγραφή :</th>
					<td><input type="text" name="z5" size="80" maxlength="80" value="<?php echo $row['description'] ?>"></td>
					</tr>
								
					
					<tr>
					<td><input name="update" type="submit" id="insPublisher" value="Ανανέωση" /></td>
					
					<td><input name="insPublisher1" type="reset" id="insPublisher1" value="Καθαρισμός Φόρμας" /></td>
					</tr>			
					
					</table>
				</form>
				
				
			<?php
			echo "<br/>";
			} //<-- end of: while ($row = $result->fetch_assoc() ) {
				$db->close();			
			?>			
			
					
			
					
		<?php		
			
	} // <-- end of : if ($_GET && !$_POST)
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

<?php
// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if (array_key_exists('update', $_POST)) {
	
	//Τεχνική έτσι βλέπω τι στέλνω στον server όταν πατάω το κουμπί "Ανανέωση".
	print_r($_POST);
	echo $s;
	
	$_POST['z1']=trim($_POST['z1']);   // isbn
	$_POST['z2']=trim($_POST['z2']);   // author
	$_POST['z3']=trim($_POST['z3']);   // title
	$_POST['z4']=trim($_POST['z4']);   // price
	$_POST['z5']=trim($_POST['z5']);   // description
	
	//----------------------------------------------------------------------
	//               Έλεγχος των Δεδομένων αν μπήκαν τα σωστά
	//----------------------------------------------------------------------
	
	if ($_POST['z2']==""){
		$message1 = "Το πεδίο Εκδότης είναι άδειο.";
	
	}else if($_POST['z1']==""){
		$message2 = "Το πεδίο ISBN  είναι άδειο.";	
	}else if(strlen($_POST['z1'])!==10){
		$message3 = "Πρέπει να εισάγεις 10 αριθμούς ακριβώς στο πεδίο ISBN.";		
	}else if(!ereg('[0123456789]{10}',$_POST['z1'])){
		$message4 =  "Πρέπει να εισάγεις μόνο αριθμούς και όχι γράμματα στο πεδίο ISBN..";
	
	}else if($_FILES['image']['name']==""){
		$message5 =  "Πρέπει να εισάγεις φωτογραφία";	
	
	}else if($_POST['z3']==""){
		$message6 = "Πρέπει να εισάγεις Τίτλο.";
		
	}else if($_POST['z4']==""){	
		$message7 = "Πρέπει να εισάγεις τιμή.";
	}else if(!ereg('[0123456789]',$_POST['z4'])){
		$message8 = "Πρέπει να εισάγεις μόνο αριθμούς στο πεδίο τιμή.";
	
	}else if($_POST['z5']==""){
		$message9 = "Πρέπει να εισάγεις Περιγραφή.";

	}else{
	
	//----------------------------------------------------------------------
	//      	Αλλαγή του ονόματος της ανεβασμένης φωτογραφίας 
	//                  με τον αριθμό isbn του βιβλίου.
	//----------------------------------------------------------------------	
		$_FILES['image']['name']=$_POST['z1'].".jpg";
		echo $_FILES['image']['name'];
	
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
		define('UPLOAD_DIR', '../images/');
		
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
					// Δεν υπάρχει λάθος, οπότε καλείται το παρακάτω αρχείο το 
					// οποίο αλλάζει το μέγεθος της εικόνας και στην συνέχεια το 
					// ανεβάζει στον server.
					include('create_thumb.inc.php');
					
		//----------------------------------------------------------------------------------------------------------
		//        και στην συνέχεια:  Εισαγωγή των Δεδομένων εφόσον είναι ο σωστός τύπος φωτογραφίας.
		//----------------------------------------------------------------------------------------------------------
		
		
		
		
		include ('db_main.php');		
		$sql = 'UPDATE books SET isbn = "'.$_POST['z1'].'",
								 author = "'.$_POST['z2'].'",
								 title = "'.$_POST['z3'].'",
								 price = "'.$_POST['z4'].'",
								 description = "'.$_POST['z5'].'" ';
									 
		$sql .= ' WHERE isbn = '.$s;
		$db->query($sql);    
		$result = $db->query($sql);
			
		if($result){		
			echo "Έγινε η Ανανέωση";
		}else{
			echo "Δεν Έγινε η Ανανέωση";
		}
			
		$db->close();		
		
					
//------------------------------------------------------------------------------------------------------------------------------------------
					break;
				case 3:
					// Λάθος 3 σημαίνει ότι το αρχείο ανέβηκε ένα μέρος του.
					// $result = "Error uploading $file. Please try again.";
					$result_error = "Υπάρχει πρόβλημα κατά το ανέβασμα του αρχείου. Ξαναπροσπάθησε πάλι.";
					
				default:
					// $result = "System error uploading $file. Contact webmaster.";
					$result_error = "Το αρχείο δεν μπορεί να ανεβεί στον server. Επικοινώνησε με τον Webmaster.";
			}
		}
		elseif ($_FILES['image']['error'] == 4) {
			// Λάθος 4 σημαίνει ότι έγινε submit στην φόρμα χωρίς να επιλεχθεί αρχείο.
			$result_error = 'Δεν έχει επιλεχθεί αρχείο.';
		}
			else {
			$result_error = "$file  δεν μπορεί να ανεβεί. </br> Μέγιστο μέγεθος αρχείου size: $max. </br> Αποδεκετεί τύποι αρχείων: gif, jpg, png.";
		}
	//}
	
	}// <-- end of if($_POST['z1']=="")
}// <-- end of if (array_key_exists('upload', $_POST)) {
// **************************************************************************************************
//                                              PHP_SELF - end
// **************************************************************************************************
?>

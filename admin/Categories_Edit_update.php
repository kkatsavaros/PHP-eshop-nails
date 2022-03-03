<?php

session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************


if ($_POST) {
	// escape quotes and apostrophes if magic_quotes_gpc off
	if (!get_magic_quotes_gpc()) {
		foreach($_POST as $key=>$value) {
			$temp = addslashes($value);
			$_POST[$key] = $temp;
		}
}
	
	
	// if the "Update author name" button has been clicked.  - Αν έχει πατηθεί το κουμπί UPDATE.
	if (array_key_exists('updateCategory', $_POST)) { 
		
		//print_r($_POST);
		
		$_POST['newNameCategory']=trim($_POST['newNameCategory']);
		$_POST['newNameCategory_en']=trim($_POST['newNameCategory_en']);
		$_POST['newNameCategory_de']=trim($_POST['newNameCategory_de']);
		$_POST['newPositionCategory']=trim($_POST['newPositionCategory']);		
	
		//----------------------------------------------------------------------
		//                          Έλεγχος των Δεδομένων
		//----------------------------------------------------------------------
			
		if ($_POST['newNameCategory']==""){
			$alert="Το πεδίο όνομα κατηγορίας είναι άδειο.";	
		}if ($_POST['newNameCategory_en']==""){
			$alert="Το πεδίο όνομα κατηγορίας Αγγλικά είναι άδειο.";	
		}if ($_POST['newNameCategory_de']==""){
			$alert="Το πεδίο όνομα κατηγορίας Γερμανικά είναι άδειο.";				
		}else if($_POST['newPositionCategory']==""){
			$alert = "Το πεδίο θέση  είναι άδειο.";
		}else if(!ereg('[0123456789]',$_POST['newPositionCategory'])){
			$alert =  "Πρέπει να εισάγεις μόνο αριθμούς στο πεδίο θέση.";
		
		
		
		}else{	
		
			
		//----------------------------------------------------------------------
		//                          Εισαγωγή των Δεδομένων 1
		//----------------------------------------------------------------------
			
		include ('db_main.php');
		$sql = 'SELECT * FROM categories WHERE catname = "'. $_POST['newNameCategory'].'"  ';  
		$result = $db->query($sql);
		
		$numrows = $result->num_rows;
		
		/* if ($numrows > 0) {
			echo "  Η Κατηγορία  <b>  ". $_POST['newNameCategory'] ."  </b> υπάρχει ήδη. Διάλεξε κάποιο άλλο όνομα.";
		} else { */
		
		if($result){
			//$sql = 'INSERT INTO  companies (company) VALUES ("'.$_POST['newNameCompany'].'")'; 

			$sql = 'UPDATE categories SET catname = "'.$_POST['newNameCategory'].'",
									      catname_en = "'.$_POST['newNameCategory_en'].'",
			                              catname_de = "'.$_POST['newNameCategory_de'].'",
										  position = "'.$_POST['newPositionCategory'].'"  
			       '; 
				   
			$sql .= 'WHERE catid = '.$_GET['num'];					
			
			$result = $db->query($sql);
		
			if ($result) {
				header('Location: Categories_Insert.php');
				exit();
			}else{
				//echo "<b> Δεν έγινε εισαγωγή</b>";		
				$alert="Δεν έγινε ανανέωση 1";
			}
		
			$db->close();
			
				
		}// <-- end of: if ($_POST['newNameCompany']==""){
	} // <-- end of: if (array_key_exists('updateCompany', $_POST)) {
}
}
	
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
			<h1>Φόρμα ανανέωσης Kατηγορίας</h1>
	</div>
	
	<?php
	//----------------------------------------------------------------------------
	//  			Για να εμφανιστούν αρχικά στα input texts
	//----------------------------------------------------------------------------
	if ($_GET) {
		
		//print_r($_GET);
		
		
		include ('db_main.php');
		$sql = "SELECT * FROM categories  WHERE catid = ".$_GET['num'];
		$result = $db->query($sql);
		$row = $result->fetch_assoc();   	
	}	
	
	?>
	
	
	
	<div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
	<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
	
	<?php
	// ----------------------------------------------------------------------------------------------------------------------------------------------
	//                                    Αρχικά τα δεδομένα εισάγονται σε texts για περαιτέρω επεξεργασία
	// ----------------------------------------------------------------------------------------------------------------------------------------------	
	?>
	<form name="authorDets" id="authorDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    
    <table class="table_categories_edit" align="center">
      <tr >
        <th scope="row" class="leftLabel">Κατηγορία Ελληνικά: </th>
        <td><input name="newNameCategory" type="text" id="first_name"  value="<?php if (isset($row['catname'])) echo $row['catname']; ?>"
        class="category_edit_update" /></td>
		<td> <img src="LanguageFlags/FlagHellas.jpg"></td>
      </tr>
	  
	  <tr >
        <th scope="row" class="leftLabel">Κατηγορία Αγγλικά: </th>
        <td><input name="newNameCategory_en" type="text" id="first_name"  value="<?php if (isset($row['catname_en'])) echo $row['catname_en']; ?>"
        class="category_edit_update" /></td>
		<td><img src="LanguageFlags/FlagEngland.jpg"></td>
      </tr>
	  	  
	  <tr >
        <th scope="row" class="leftLabel">Κατηγορία Γερμανικά: </th>
        <td><input name="newNameCategory_de" type="text" id="first_name"  value="<?php if (isset($row['catname_de'])) echo $row['catname_de']; ?>"
        class="category_edit_update" /></td>
		<td><img src="LanguageFlags/FlagDe.png"></td>
      </tr>
	  
	  
	  <tr>
        <th scope="row" class="leftLabel">Θέση: </th>
        <td><input name="newPositionCategory" type="text" id="first_name" value="<?php if (isset($row['position'])) echo $row['position']; ?>" 
        class="category_edit_update" /></td>
      </tr>
	  
      <tr>
      	<th><input name="author_id"      type="hidden" id="author_id"   value="<?php if (isset($row['id'])) echo $row['id']; ?>" /></th>
      	<td><input name="updateCategory" type="submit" id="updateAXXXX" value="Ανανέωση Δεδομένων" /></td>
      </tr>
	  
	  
    </table>
	
  	</form>
	
	<?php
	$db->close();
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
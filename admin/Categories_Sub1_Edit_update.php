<?php

session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************
if (!$_GET['num']){
	echo "fuck off";
	exit();
}

	
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
	
		//----------------------------------------------------------------------
		//                          Έλεγχος των Δεδομένων
		//----------------------------------------------------------------------
			
		if ($_POST['newNameCategory']==""){
			$message="Το πεδίο Κατηγορία στα Ελληνικά είναι άδειο.";
		}if ($_POST['newNameCategory_en']==""){
			$message="Το πεδίο Κατηγορία στα Αγγλικά είναι άδειο.";
		}if ($_POST['newNameCategory_de']==""){
			$message="Το πεδίο Κατηγορία στα Γερμανικά είναι άδειο.";
			
		}else{
			
		//----------------------------------------------------------------------
		//                          Εισαγωγή των Δεδομένων
		//----------------------------------------------------------------------
		
		include ('db_main.php');
		$sql = 'SELECT * FROM categories_sub1 WHERE subcatname = "'. $_POST['newNameCategory'].'"  ';  
		$result = $db->query($sql);
		
		$numrows = $result->num_rows;
		
		/*if ($numrows > 0) {
			echo "  Η Κατηγορία : <b>  ". $_POST['newNameCategory'] ."  </b> υπάρχει ήδη. Διάλεξε κάποιο άλλο όνομα.";
		} else {*/
			$sql = 'UPDATE categories_sub1 SET subcatname = "'.$_POST['newNameCategory'].'",
			                                   subcatname_en = "'.$_POST['newNameCategory_en'].'",
			                                   subcatname_de = "'.$_POST['newNameCategory_de'].'"
			
					';        													 
			$sql .= 'WHERE subcatid = '.$_GET['num'];					
			
			$result = $db->query($sql);
		
			if ($result) {
				//echo "<b>"."  Έχουν εισαχθεί στην βάση δεδομένων: "."</b><br>";
				//echo "<b>"."  Εταιρία : </b>".$_POST['newNameCompany']."<br>";
				//$message="Έχει γίνει ανανέωση στης Εταιρίας:  ".$_POST['newNameCompany'];
				//header('Location: Categories_Edit.php?title='.$_POST['newNameCategory']);
				
				header('Location: Categories_Sub1_Insert.php');
				exit();
			}else{
				//echo "<b> Δεν έγινε εισαγωγή</b>";		
				$message="Δεν έγινε ανανέωση";
			}
		
			$db->close();
	//	}// <-- end of: if ($numrows > 0)			ok
				
		}// <-- end of: if ($_POST['newNameCompany']==""){
	} // <-- end of: if (array_key_exists('updateCompany', $_POST)) {
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
				<h1> Φόρμα Επεξεργασίας Υποπροϊόντων </h1>
			</div>	
			<?php
	//----------------------------------------------------------------------------
	//  			Για να εμφανιστούν αρχικά στα input texts
	//----------------------------------------------------------------------------
	if ($_GET) {
		
		//print_r($_GET);
				
		include ('db_main.php');
		$sql = "SELECT * FROM categories_sub1  WHERE subcatid = ".$_GET['num'];
		$result = $db->query($sql);
		$row = $result->fetch_assoc();    	
	}	
	
	?>
	
	<form name="authorDets" id="authorDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
	
    <table class="table_subcategories_edit_update" align="center" >
	
      <tr>
        <th scope="row" class="leftLabel">Κατηγορία στα Ελληνικά : </th>
        <td><input name="newNameCategory" type="text" id="first_name" class="mediumbox" value="<?php if (isset($row['subcatname'])) echo $row['subcatname']; ?>"/></td>
		<td> <img src="LanguageFlags/FlagHellas.jpg"></td>
      </tr>
	  
	   <tr>
        <th scope="row" class="leftLabel">Κατηγορία στα Αγγλικά : </th>
        <td><input name="newNameCategory_en" type="text" id="first_name" class="mediumbox" value="<?php if (isset($row['subcatname_en'])) echo $row['subcatname_en']; ?>"/></td>
		<td><img src="LanguageFlags/FlagEngland.jpg"></td>
      </tr>
	  
	   <tr>
        <th scope="row" class="leftLabel">Κατηγορία στα Γερμανικά : </th>
        <td><input name="newNameCategory_de" type="text" id="first_name" class="mediumbox" value="<?php if (isset($row['subcatname_de'])) echo $row['subcatname_de']; ?>"/></td>
		<td><img src="LanguageFlags/FlagDe.png"></td>
      </tr>
	  
	  
      <tr>
      	<th><input name="author_id" type="hidden" id="author_id"  value="<?php if (isset($row['id'])) echo $row['id']; ?>" /></th>
      	<td><input name="updateCategory" type="submit" id="updateAXXXX" value="Ανανέωση" /></td>
      </tr>
	  
	  <tr>
	  	<td><?php if(isset($message)) echo $message;?></td>
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
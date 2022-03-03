<?php
session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

if($_GET['do']){	
	$alert="Δεν μπορεί να διαγραφεί αυτή η υποκατηγορία γιατί έχει βιβλία.";
}

if($_GET['ok']){	
	$message="<br>"." Έχει γίνει η διαγραφή της κατηγορίας."."<br><br>";
}

// **************************************************************************************************
//                                              PHP_SELF - start
// **************************************************************************************************

if($_POST){	
	//print_r($_POST);
	
	$_POST['zcat1']=trim($_POST['zcat1']);
	$_POST['zcat1_en']=trim($_POST['zcat1_en']);
	$_POST['zcat1_de']=trim($_POST['zcat1_de']);
	$_POST['zcat2']=trim($_POST['zcat2']);     
	$_POST['abc']=trim($_POST['abc']);
	
	//----------------------------------------------------------------------
	//                          Έλεγχος των Δεδομένων
	//----------------------------------------------------------------------
		
	if ($_POST['zcat1']==""){
		$alert="Το πεδίο όνομα υποκατηγορίας στα Ελληνικά είναι άδειο.";		
	
	}if ($_POST['zcat1_en']==""){
		$alert="Το πεδίο όνομα υποκατηγορίας στα Αγγλικά είναι άδειο.";		
	
	}if ($_POST['zcat1_de']==""){
		$alert="Το πεδίο όνομα υποκατηγορίας στα Γερμανικά είναι άδειο.";				
		
	}else if($_POST['zcat2']==""){
		$alert="Το πεδίο θέση υποκατηγορίας είναι άδειο.";
		
	}else if(!ereg('[0123456789]',$_POST['zcat2'])){		
		$alert =  "Πρέπει να εισάγεις μόνο αριθμούς και όχι γράμματα στο πεδίο θέση υποκατηγορίας.";	
		
	}else{
	
			//----------------------------------------------------------------------
			//                          Εισαγωγή των Δεδομένων 
			//----------------------------------------------------------------------
			
			include ('db_main.php');
			$sql = 'SELECT * FROM categories_sub1 WHERE subcatname = "'. $_POST['zcat1'].'"  ';  
			$result = $db->query($sql);
			
			$numrows = $result->num_rows;
			
			if ($numrows > 0) {
				$alert= "  Η κατηγορία  <b>  ". $_POST['zcat1'] ."  </b> υπάρχει ήδη. Διάλεξε κάποιο άλλο όνομα.";
			} else {
				$sql = 'INSERT INTO  categories_sub1 (catid,subcatname,subcatname_en,subcatname_de,position) 
											 VALUES ("'.$_POST['abc'].'",
													 "'.$_POST['zcat1'].'",
													 "'.$_POST['zcat1_en'].'",
													 "'.$_POST['zcat1_de'].'",
													 "'.$_POST['zcat2'].'"	
													 
													 )'; 
				$result = $db->query($sql);
				
				if ($result) {
					//$message="Έχει εισαχθεί η υποκατηγορία:  ".$_POST['zcat1']." στην θέση ".$_POST['zcat2'];
					header('Location: Categories_Sub1_Insert.php');
					exit();
				}else{
					//echo "<b>  Δεν έγινε εισαγωγή</b>";
					$alert="Δεν έγινε εισαγωγή. Υπάρχει κάποιο πρόβλημα.";
				} // <-- end of : else
			
				$db->close();
				
			}// <-- end of if ($numrows > 0)
			//----------------------------------------------------------------------
			//                    Τέλος : Εισαγωγή των Δεδομένων 
			//----------------------------------------------------------------------

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
		function checkDel(who,id) {
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγράψεις την Yποκατηγορία :  '+who+'?';
			if (confirm(msg))
				location.replace('Categories_Sub1_Delete.php?category='+who+'&id='+id);
			}
			
		function isNumberKey(evt)
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			 return true;
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
				<h1> Φόρμα Εισαγωγής καινούργιας Υποκατηγορίας προϊόντων </h1>
			</div>			
			
			<table>
			<tr>
			<td>
			<?php include("jQuery_Tree.php"); ?>
			</td>
			
			<td>
			<div id="blue"> <?php if(isset($message)) echo "<br>".$message; ?> </div>
			<div id="red_alert">  <?php if(isset($alert)) echo "<br> Προσοχή : ".$alert; ?>   </div>
			
			<form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
			
				<table class="table_subcategories_insert" align="center">
				<caption>Εισαγωγή Υποκατηγορίας</caption>
					
				<tr><th>Όνομα υποκατηγορίας Ελληνικά: </th><td><input type="text" name="zcat1" size="40" maxLength="40" class="sub_category_insert"
				value="<?php if (isset($_POST['zcat1'])) echo $_POST['zcat1']; ?>"></td>
				<td> <img src="LanguageFlags/FlagHellas.jpg"></td></tr>
				
				<tr><th>Όνομα υποκατηγορίας Αγγλικά: </th><td><input type="text" name="zcat1_en" size="40" maxLength="40" class="sub_category_insert"
				value="<?php if (isset($_POST['zcat1_en'])) echo $_POST['zcat1_en']; ?>"></td>
				<td><img src="LanguageFlags/FlagEngland.jpg"></td></tr>
				
				<tr><th>Όνομα υποκατηγορίας Γερμανικά: </th><td><input type="text" name="zcat1_de" size="40" maxLength="40" class="sub_category_insert"
				value="<?php if (isset($_POST['zcat1_de'])) echo $_POST['zcat1_de']; ?>"></td>
				<td><img src="LanguageFlags/FlagDe.png"></td></tr>
				
				
				<tr><th>Θέση υποκατηγορίας : </th><td><input type="text" name="zcat2" size="5" maxLength="5" class="sub_category_insert" onkeypress='return isNumberKey(event)'
				value="<?php if (isset($_POST['zcat2'])) echo $_POST['zcat2']; ?>"></td></tr>
				
				<tr>
				<th>Κατηγορία :</th>
				<td><?php  // ------------------------  Πρώτο ComboBox Κατηγορία ---------------------------------------
					
					include ('db_main.php');
					$sql='SELECT * FROM categories ';
					$result = $db->query($sql);
					
					$numrows = $result->num_rows;
					?>
					
					<select name="abc"  id="company" class="sub_category_insert">
				
					<?php
					while ($row = $result->fetch_assoc()) {
						echo "<option value=".$row['catid']." > ".$row['catname']." </option>";
					}
					
					$db->close();
					?>		
					</select>
				</td>
				</tr>	
				
				<tr>&nbsp;</tr><td>&nbsp;</td>
				<tr>
					<td><input name="insert" type="submit" id="insert_button" value="Εισαγωγή" /></td>
					<td><input name="insert" type="reset"  id="insert_button"  value="Καθαρισμός Φόρμας" /></td>
				</tr>				
				</table>
			</form>
			
			</td>
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
<?php
session_start();
	
if (!isset($_SESSION['authenticated'])){	                      
	header('Location: index.php');
	exit();
}

if($_GET['do']){	
	$alert="Δεν μπορεί να διαγραφεί αυτή η κατηγορία γιατί έχει υποκατηγορίες";
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
	
	//----------------------------------------------------------------------
	//                          Έλεγχος των Δεδομένων
	//----------------------------------------------------------------------
		
	if ($_POST['zcat1']==""){
		$alert="Το πεδίο όνομα κατηγορίας στα Ελληνικάείναι άδειο.";		
		
	}if ($_POST['zcat1_en']==""){
		$alert="Το πεδίο όνομα κατηγορίας στα Αγγλικά είναι άδειο.";		

	}if ($_POST['zcat1_de']==""){
		$alert="Το πεδίο όνομα κατηγορίας στα Γερμανικά είναι άδειο.";				
		
	}else if($_POST['zcat2']==""){
		$alert="Το πεδίο θέση κατηγορίας είναι άδειο.";
		
	}else if(!ereg('[0123456789]',$_POST['zcat2'])){		
		$alert= "Πρέπει να εισάγεις μόνο αριθμούς και όχι γράμματα στο πεδίο θέση κατηγορίας.";	
		
	}else{
	
	//----------------------------------------------------------------------
	//                          Εισαγωγή των Δεδομένων
	//----------------------------------------------------------------------
	
	include ('db_main.php');
	$sql = 'SELECT * FROM categories WHERE catname = "'. $_POST['zcat1'].'"  OR position = "'. $_POST['zcat2'].'"  ';  
	$result = $db->query($sql);
	
	$numrows = $result->num_rows;
	
	
	// --------------------------------------------------------------------------
	
	if ($numrows > 0) {
		$alert= "  Η κατηγορία  <b>  ". $_POST['zcat1'] ."  </b> υπάρχει ήδη. Διάλεξε κάποιο άλλο όνομα."."<br>"
				." ή η θέση " . $_POST['zcat2'] . " υπάρχει ήδη.";
		
	} else {
		$sql = 'INSERT INTO  categories (catname,catname_en,catname_de,position) 
								 VALUES ("'.$_POST['zcat1'].'",
								         "'.$_POST['zcat1_en'].'",
								         "'.$_POST['zcat1_de'].'",								 
								 		 "'.$_POST['zcat2'].'"	)'; 
		$result = $db->query($sql);
		
		if ($result) {
			//$message="Έχει εισαχθεί η Κατηγορία:  ".$_POST['zcat1']." στην θέση ".$_POST['zcat2'];
			header('Location: Categories_Insert.php');  //OK
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
		function checkDel(who,id) {
			var msg = 'Είσαι σίγουρος ότι θέλεις να διαγράψεις την Κατηγορία '+who+'?';
			if (confirm(msg))
				location.replace('Categories_Delete.php?category='+who+'&id='+id);
			}
	
		<!-- Για τα input zip και telephone να γράφουν μόνο αριθμούς και backspace. -->
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
			<h1> Φόρμα Εισαγωγής καινούργιας Κατηγορίας προϊόντων </h1>
		</div>			
        	
            <div id="blue"> <?php if(isset($message)) echo $message; ?> </div>
			<div id="red_alert">  <?php if(isset($alert)) echo "Προσοχή : ".$alert; ?>   </div>
            
			<?php
			//----------------------------------------------------------------------
			//                      Εισαγωγή νέας Κατηγορίας
			//----------------------------------------------------------------------			
			?>
						
			<table class="table_categories_insert" align="center">
			<caption>Εισαγωγή Κατηγορίας</caption>
				<form name="publisherDets" id="publisherDets" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">				
					
				<tr><th>Όνομα Κατηγορίας Ελληνικά:</th>
				<td><input type="text" name="zcat1" size="40" maxLength="40" class="category_insert" 
				value="<?php if (isset($_POST['zcat1'])) echo $_POST['zcat1']; ?>"></td>
				<td> <img src="LanguageFlags/FlagHellas.jpg"></td></tr>
				
				<tr><th>Όνομα Κατηγορίας Αγγλικά: </th>
				<td><input type="text" name="zcat1_en" size="40" maxLength="40" class="category_insert" 
				value="<?php if (isset($_POST['zcat1_en'])) echo $_POST['zcat1_en']; ?>"></td>
				<td><img src="LanguageFlags/FlagEngland.jpg"></td></tr>
				
				<tr><th>Όνομα Κατηγορίας Γερμανικά: </th>
				<td><input type="text" name="zcat1_de" size="40" maxLength="40" class="category_insert" 
				value="<?php if (isset($_POST['zcat1_de'])) echo $_POST['zcat1_de']; ?>"></td>
				<td><img src="LanguageFlags/FlagDe.png"></td></tr>
				
				
				<tr><th>Θέση Κατηγορίας : </th><td><input type="text" name="zcat2" size="5" maxLength="5" class="category_insert" onkeypress='return isNumberKey(event)'
				value="<?php if (isset($_POST['zcat2'])) echo $_POST['zcat2']; ?>"></td></tr>
									
				<tr>
					<td><input name="insPublisher" type="submit" id="insPublisher" value="Εισαγωγή" /></td>
					<td><input name="insPublisher" type="reset"  id="insPublisher" value="Καθαρισμός Φόρμας" /></td>
				</tr>				
					
				</form>
			</table>
			
            
            
			<?php 
			//----------------------------------------------------------------------
			//                      Εμφάνιση όλων των Κατηγοριών
			//----------------------------------------------------------------------
				
			//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');			
			include ('db_main.php');
			$sql='SELECT * FROM categories ORDER BY position ASC'; 
			
			$result = $db->query($sql);			
			$numrows = $result->num_rows;
			
			if($numrows==0){
				echo "<div class=center>Δεν υπάρχουν κατηγορίες.</div>";
				echo "<br>";
			}else{
			?>
			<table class="table_categories_show" align="center">
			<caption>Εμφάνιση Κατηγοριών</caption>
			
            <colgroup>
				<col class="abc1">
				<col class="abc2">
				<col class="abc3">		
				<col class="abc4">		
               	<col class="abc5">	
				<col class="abc4">
				<col class="abc4">				
			</colgroup>			
			
			
			<tr class="main"> <th>Α/Α</th> <th>catid</th> <th>Κατηγορία</th> <th>Αγγλικά</th> <th>Γερμανικά</th> <th>Θέση</th> <th></th> <th></th> </tr>
			<?php
			
			$i = 1;   // Για τα χρώματα του πίνακα.
			$counter=1;
			while ($row = $result->fetch_assoc()) {	 
			?>					                                                                                                   
				<tr class="<?php echo $i%2 ? 'nohilite' : 'hilite'; ?>">
					  <td><?php echo $counter;?>                   </td>
					  <td><?php echo $row['catid']?>               </td>                    
				      <td><?php echo $row['catname']?>             </td> 
					  <td><?php echo $row['catname_en']?>          </td> 
					  <td><?php echo $row['catname_de']?>          </td> 
					  <td><?php echo $row['position']?>            </td> 
					  
					  <td><a href="Categories_Edit_update.php?num=<?php echo $row['catid']; ?>"    >Επεξεργασία</a></td>
    				  <td><a href="javascript:checkDel(  '<?php echo addslashes($row['catname']); ?>'  ,  <?php echo $row['catid']; ?>  )"    >Διαγραφή</a></td>
				</tr>			
			
			<?php
				$i++;
				$counter++;
			}
				$db->close();	
			}
			?>
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
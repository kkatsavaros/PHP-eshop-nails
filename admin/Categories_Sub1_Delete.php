<?php
	if (isset($_GET['id'])) {
				
		//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
		include ('db_main.php');
		$sql = 'SELECT * FROM books WHERE subcatid = '.$_GET['id'];
		$result = $db->query($sql);
		$numrows = $result->num_rows;
		
		if($numrows>0){
			header('Location: Categories_Sub1_Insert.php?do=not');
			exit();			
		}else{			
				
		//print_r($_GET);
							  
		// if query string includes id. - ?? t? e??t?µa pe????e? t? id.
					
		//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
		include ('db_main.php');
		$sql = 'DELETE FROM categories_sub1 WHERE subcatid = '.$_GET['id'];
		$result = $db->query($sql);
								
		if ($result) {
			//echo "<b>"."  ??e? d?a??afe? ap? t?? ß?s? ded?µ????: "."</b><br>";
			//echo "<b>"."  ? ?at?????a : </b>".$_GET['category']."<br>";							
								
			header('Location: Categories_All.php');			                  
			exit();
		}
		
		}
		$db->close();
	} //end of: if (isset($_GET['id'])) {
?>	
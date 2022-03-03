<?php
	//------------------------------------------------------------------
	//						Διαγραφή Κατηγορίας
	//------------------------------------------------------------------
	if (isset($_GET['id'])) {
				
		//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
		include ('db_main.php');		
		$sql = 'SELECT * FROM categories_sub1 WHERE catid = '.$_GET['id'];
		$result = $db->query($sql);
		$numrows = $result->num_rows;
		
		if($numrows>0){
			header('Location: Categories_Insert.php?do=not');
			exit();
		}else{				
				
			//print_r($_GET);				  
								  
			// if query string includes id. - Αν το ερώτημα περιέχει το id.
						
			//$db_2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
			include ('db_main.php');
			$sql_2 = 'DELETE FROM categories WHERE catid = '.$_GET['id'];
			$result_2 = $db_2->query($sql_2);
			
			if ($result_2) {
				//echo "<b>"."  Έχει διαγραφεί από την βάση δεδομένων: "."</b><br>";
				//echo "<b>"."  Η Κατηγορία : </b>".$_GET['category']."<br>";							
									
				header('Location: Categories_Insert.php?ok=ok?');
				exit();
			}
			$db_2->close();
		}
		
		$db->close();
		
	}
?>	
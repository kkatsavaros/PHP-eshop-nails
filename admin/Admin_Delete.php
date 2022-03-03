<?php
	//------------------------------------------------------------------
	//						Διαγραφή Διαχειριστή
	//------------------------------------------------------------------
	if (isset($_GET['username'])) {
		
    	//$db = new mysqli('localhost', 'phpnet_bookadm', 'password', 'phpnet_book');
		include ('db_main.php');
		$sql = 'DELETE FROM admin WHERE surname = "'.$_GET['surname'].'"';		
		$result = $db->query($sql);
		$numrows = $result->num_rows;
			
		if($result){
			header('Location: Admin.php?ok=ok');			
		}else{				
			header('Location: Admin.php?do=not');			
		}
				
		$db->close();
	}	
?>	
<?php 				  
	
	include ('db_main.php');
	if (!get_magic_quotes_gpc()) stripslashes($_GET['isbn']);
	
	
	// if query string includes id. - Αν το ερώτημα περιέχει το id.
	if (isset($_GET['isbn']) ) {
		
		
		$isbn2=$_GET['isbn'];
		$sql = "DELETE FROM books WHERE isbn = "."'$isbn2'";
		$result = $db->query($sql);
							
		if ($result) {
							
			//-------------------------------------------
			//         Διαγραφή της φωτογραφίας
			//-------------------------------------------
			function fileDelete($filepath,$filename) {
				$success = FALSE;
				if (file_exists($filepath.$filename)&&$filename!=""&&$filename!="n/a") {
					unlink ($filepath.$filename);
					$success = TRUE;
				}
				return $success;	
			}						
							
							
			$a=$_GET['isbn'].".jpg";
			fileDelete('../download/',$a);
			//------------------------------------------
			
			header('Location: Products_Show.php?ok=ok');	
		}else{
			header('Location: Products_Show.php?do=not');	
		} // end of : if ($result) {
				
			$db->close();
	} // end of: if (isset($_GET['isbn']) ) {
?>					
			
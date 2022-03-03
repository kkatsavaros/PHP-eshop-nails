<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="jQuery_tree_Library/jquery.treeview.css">
	
<script type="text/javascript" src="jQuery_tree_Library/jquery.min.js"       ></script>	
<script type="text/javascript" src="jQuery_tree_Library/jquery.cookie.js"    ></script>	
<script type="text/javascript" src="jQuery_tree_Library/jquery.treeview.js"  ></script>		
<script type="text/javascript" src="jQuery_tree_Library/demo.js"             ></script>
	
<div id="jQuery_Tree">
	
	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="#"> Collapse All</a> | 
		<a title="Expand the entire tree below" href="#"> Expand All</a> | 
		<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>
	</div>
	
	<ul id="red" class="treeview-red">
	<!-- ul id="browser" class="filetree" -->
		<?php
			//$db = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
			include ('db_main.php');
			$sql='SELECT * FROM categories ORDER BY position ASC'; 
			$result = $db->query($sql);
			$numrows = $result->num_rows;
			//echo "<b>Συνολικός αριθμός Κατηγοριών  : </b>".$numrows."<br><br>";  			
			//$i = 1;       // Για τα χρώματα του πίνακα.
			//$counter=1;
			echo " e-shop ";
		?>
					
					
		<?php
			while ($row = $result->fetch_assoc()) {	 
				
				echo "<li><b>".$row['catname']."</b>";		
						
				//--------------------------------------------------------------
				//$db_2 = new mysqli('localhost', 'book_sc', 'password', 'book_sc');
				include ('db_main.php');
				$sql_2 = "SELECT * FROM categories_sub1 WHERE catid = ".$row['catid'];     // Συσχέτιση βάσεων δεδομένων.
				$result_2 = $db->query($sql_2);
				//$row = $result->fetch_assoc();			
				$numrows_2 = $result_2->num_rows;
						
				
				while ($row_2 = $result_2->fetch_assoc() ) {
					echo "<ul>".$row_2['subcatname']
					."  |   "
					."<a href=Categories_Sub1_Edit_update.php?num=".$row_2['subcatid'].">Επεξεργασία</a>"
					."  |   "
					."<a href=\"javascript:checkDel('".$row_2['subcatname']."','".$row_2['subcatid']."')\"    >Διαγραφή</a>" 
					."</ul>"  ;
				} 		
				//----------------------------------------------------------------
				echo "</li>";	
					
			}
				$db->close();	
		?>

	</ul>
</div> <!-- end of : <div id="jQuery_Tree" -->			
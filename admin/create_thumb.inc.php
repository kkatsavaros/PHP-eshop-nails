<?php

	// define constants
	// Που θα είναι το ανεβασμένο.
	define('THUMBS_DIR', '../download/');  
	define('MAX_WIDTH', 1000);
	define('MAX_HEIGHT', 562);
  
	// process the uploaded image
if (is_uploaded_file($_FILES['image']['tmp_name'])) {
	
    $original = $_FILES['image']['tmp_name'];
	
	// test 1:
	$a=getimagesize($original);
	
	//echo "<pre>";
	//print_r($a);
	//echo "</pre>";
		
		
		
	// begin by getting the details of the original
	//Η συνάρτηση list μετατρέπει τα στοιχεία ενός πίνακα σε μεταβλητές. Δηλαδή τις μεταβλητές $width, $height, $type.
    list($width, $height, $type) = getimagesize($original);
	
	// test 2: 
	//echo "<br><b> 2. width original</b>: ".$width;
	//echo "<br><b> 3. height original </b>: ".$height;
	//echo "<br><b> 4. type original</b>: ".$type;
		
		
		
		
		
		
		
		
	// calculate the scaling ratio
	// Υπολογισμός της συμπήκνωσης.
		
    if ($width <= MAX_WIDTH && $height <= MAX_HEIGHT) {
    	$ratio = 1;
    }elseif ($width > $height) {
     	$ratio = MAX_WIDTH/$width;
    }else {
    	$ratio = MAX_HEIGHT/$height;
    }	 
	//test 3:
	//echo "<br><b>5. Scalling ratio </b>: ".$ratio;
		
		
	
	$imagetypes = array('/\.gif$/', '/\.jpg$/', '/\.jpeg$/', '/\.png$/');      // strip the extension off the image filename
	$name = preg_replace($imagetypes, '', basename($_FILES['image']['name'])); // Αντικατέστησε το 1 με το κενό στην μεταβλητή 3.
	//test 4: 
	//echo "<br><b> 6. Clean name </b>: ".$name;     // fugi σκέτο όχι fugi.jpg
		
		
		
		
	// create an image resource for the original
	switch($type) {
		case 1:
			$source = @ imagecreatefromgif($original);
	
			if (!$source) {
				$result = 'Cannot process GIF files. Please use JPEG or PNG.';
			}
			break;
		  	
		case 2:
			$source = imagecreatefromjpeg($original);
			break;
		
		case 3:
			$source = imagecreatefrompng($original);
			break;
		  
		default:
			$source = NULL;
			$result = 'Cannot identify file type.';
		}
		// test 5:
		//echo "<br><b> 7. Source </b>: ".$source; 
		
		
		
		// make sure the image resource is OK
		if (!$source) {
			$result = 'Problem copying original';
		} else {
			// calculate the dimensions of the thumbnail
			$thumb_width = round($width * $ratio);      // Επιστρέφει στον πλησιέστερο ολόκληρο αριθμό. 
			$thumb_height = round($height * $ratio);
			// test 6:
		//	echo "<br><b> 8. thumb_width </b>: ".$thumb_width; 
		//	echo "<br><b> 9. thumb_height </b>: ".$thumb_height; 
			
			
			
			// create an image resource for the thumbnail			
			$thumb = imagecreatetruecolor($thumb_width, $thumb_height); // Δημουργεί έναν μαυροπίνακα με τις διαστάσεις που δίνουμε.
			//echo "<br><b> 10. thumb </b>: ".$thumb;

			
			// create the resized copy
			// Εδώ γίνεται αλλαγή διαστάσεων
			//imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width_cropped, $thumb_height_cropped, $width_original, $height_original);
			imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
			//Καταρχάς δεν χρειάζεται να αναθέσουμε το αποτέλεσμα σε κάποια μεταβλητή. Η μεταβλητή $thumb περιέχει την περικομμένη εικόνα.
			// test 7:
		//	echo "<br><b> 10. thumb </b>: ".$thumb; 

			
			 // Η συνάρτηση που σώζει μια εικόνα σε ένα αρχείο χρειάζεται να ξέρει τι τύπος αρχείου είναι.
			// save the resized copy
			switch($type) {
			 	case 1:
					if (function_exists('imagegif')) {
						$success = imagegif($thumb, THUMBS_DIR.$name.'.gif');
						$thumb_name = $name.'.gif';
					}
					else {
						$success = imagejpeg($thumb, THUMBS_DIR.$name.'.jpg', 50);
						$thumb_name = $name.'.jpg';
					}
					break;
							  
					case 2:
						$success = imagejpeg($thumb, THUMBS_DIR.$name.'.jpg', 100);
						$thumb_name = $name.'.jpg';
						break;
						
					case 3:
						$success = imagepng($thumb, THUMBS_DIR.$name.'.png');
						$thumb_name = $name.'_thb.png';
			 }
					
			if ($success) {
				$result = "$thumb_name δημιουργήθηκε";
			}else {
				$result = 'Πρόβλημα δημιουργίας thumbnail';
			}
				
			// remove the image resources from memory
			imagedestroy($source);
			imagedestroy($thumb);
		}  //<-- end of switch($type) { 
	}  //<-- end of if (!$source) {
?>
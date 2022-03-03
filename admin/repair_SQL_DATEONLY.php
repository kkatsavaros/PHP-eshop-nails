<?php
	function repair_SQL_DATEONLY($theString) {
					$arr1=explode(" ", $theString);
					$arrDate=explode("-", $arr1[0]);
					$arrdate2=array_reverse($arrDate);
					$arrDate3=implode("-", $arrdate2);
				
					return $arrDate3;
	}
?>
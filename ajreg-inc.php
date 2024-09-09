<?php

session_start();
require 'database.php';//Add database connection

if (isset($_GET['id'])){
	$szivid = $_GET['id'];
	
	if (empty($szivid)){
		header("Location: index.php?error=emptyfields&id=".$szivid);
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*/", $id)){
		header("Location: index.php?error=invalidszivid&szivid=".$szivid);
		exit();
	}
	
	else{	
		$sql = "SELECT id FROM aetp WHERE szivid = ?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: index.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $szivid);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowCount = mysqli_stmt_num_rows($stmt);
			
			if ($rowCount > 0) {
				header("Location: index.php?error=szividtaken".$szivid);
				exit();
			} else {
				$sql = "INSERT INTO aetp (szivid) VALUES (?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: index.php?error=sqlerror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "s", $szivid);
					mysqli_stmt_execute($stmt);
					$_SESSION['sessionszivid'] = $szivid;
						header("Location: product.html?succes=registered");
						exit();
				}	
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>
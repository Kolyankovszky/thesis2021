<?php

session_start();
require 'database.php';//Add database connection

if (isset($_GET['cikkszam'])){
	$cikkszam = $_GET['cikkszam'];
	
	if (empty($cikkszam)){
		header("Location: product.html?error=emptyfields&cikkszam=".$cikkszam);
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*/", $cikkszam)){
		header("Location: index.php?error=invalidalkid&cikkszam=".$cikkszam);
		exit();
	}
	
	else{	
		$sql = "SELECT id FROM aeta WHERE cikkszam = ?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: product.html?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $cikkszam);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowCount = mysqli_stmt_num_rows($stmt);
			
			if ($rowCount > 0) {
				header("Location: product.html?error=cikkszamtaken".$cikkszam);
				exit();
			} else {
				$sql = "INSERT INTO aeta (cikkszam) VALUES (?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: product.html?error=sqlerror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "s", $cikkszam);
					mysqli_stmt_execute($stmt);
					$_SESSION['sessioncikkszam'] = $cikkszam;
						header("Location: ajanlat.php?succes=registered");
						exit();
				}	
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>
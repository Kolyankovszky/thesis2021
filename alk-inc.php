<?php

if (isset($_POST['submit'])){
	//Add database connection
	require 'database.php';
	
	$rajzszam 	= $_POST['rajzszam'];
	$leiras 	= $_POST['leiras'];
	$szivmenny 	= $_POST['szivmenny'];
	$cikkszam 	= $_POST['cikkszam'];
	$megj 		= $_POST['megj'];
	
	if (empty($rajzszam) || empty($leiras) || empty($szivmenny) || empty($cikkszam) || empty($megj)){
		header("Location: alk.php?error=emptyfields&leiras=".$leiras);
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*/", $rajzszam)){
		header("Location: alk.php?error=invalidrajzszam&rajzszam=".$rajzszam);
		exit();
	}
	
	else{	
		$sql = "SELECT cikkszam FROM alk WHERE cikkszam = ?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: alk.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $cikkszam);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowCount = mysqli_stmt_num_rows($stmt);
			
			if ($rowCount > 0) {
				header("Location: alk.php?error=cikkszamtaken");
				exit();
			} else {
				$sql = "INSERT INTO alk (rajzszam, leiras, szivmenny, cikkszam, megj) VALUES (?, ?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: alk.php?error=sqlerror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "sssss", $rajzszam, $leiras, $szivmenny, $cikkszam, $megj);
					mysqli_stmt_execute($stmt);
						header("Location: alk.php?succes=registered");
						exit();
				}	
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>
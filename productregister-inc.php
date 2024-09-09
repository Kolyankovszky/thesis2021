<?php

session_start();
require 'database.php';

if (isset($_POST['submit'])){
	$pumpmarka = $_POST['pumpmarka'];
	$pumpmodell = $_POST['pumpmodell'];
	$pumpsorozat = $_POST['pumpsorozat'];
	$pumpgyariszam = $_POST['pumpgyariszam'];
	$ugyfelid = $_SESSION['sessionid'];
	
	if (empty($pumpmarka) || empty($pumpmodell) || empty($pumpsorozat) || empty($pumpgyariszam) || empty($ugyfelid)){
		header("Location: index.php?error=emptyfields&pumpmodell=".$ugyfelid);
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*/", $pumpmodell)){
		header("Location: index.php?error=invalidpumpmodell&pumpmodell=".$pumpmodell);
		exit();
	}
	
	else{	
		$sql = "SELECT pumpmodell FROM szivattyuk WHERE pumpmodell = ?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: index.php?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $pumpmodell);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowCount = mysqli_stmt_num_rows($stmt);
			
			if ($rowCount > 0) {
				header("Location: index.php?error=pumpmodelltaken");
				exit();
			} else {
				$sql = "INSERT INTO szivattyuk (pumpmarka, pumpmodell, pumpsorozat, pumpgyariszam, ugyfelid) VALUES (?, ?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: index.php?error=sqlerror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "sssss", $pumpmarka, $pumpmodell, $pumpsorozat, $pumpgyariszam, $ugyfelid);
					mysqli_stmt_execute($stmt);
						header("Location: index.php?succes=registered");
						exit();
				}	
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>
<?php

if (isset($_POST['submit'])){
	//Add database connection
	require 'database.php';
	
	$cegnev 			= $_POST['cegnev'];
	$kapcsolatnev 		= $_POST['kapcsolatnev'];
	$email 				= $_POST['email'];
	$password 			= $_POST['password'];
	$confirmpassword 	= $_POST['confirmpassword'];
	
	if (empty($cegnev) || empty($kapcsolatnev) || empty($email) || empty($password) || empty($confirmpassword)){
		header("Location: index.html?error=emptyfields&cegnev=".$cegnev);
		exit();
	} elseif (!preg_match("/^[a-zA-Z0-9]*/", $cegnev)){
		header("Location: index.html?error=invalidcegnev&cegnev=".$cegnev);
		exit();
	}elseif($password !== $confirmpassword){
		header("Location: index.html?error=passwordsdonotmatch&cegnev=".$cegnev);
		exit();
	}
	
	else{	
		$sql = "SELECT email FROM ugyfel WHERE email = ?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: index.html?error=sqlerror");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowCount = mysqli_stmt_num_rows($stmt);
			
			if ($rowCount > 0) {
				header("Location: index.html?error=emailtaken");
				exit();
			} else {
				$sql = "INSERT INTO ugyfel (cegnev, kapcsolatnev, email, password) VALUES (?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: index.html?error=sqlerror");
					exit();
				} else {
					$hashedPass = password_hash($password, PASSWORD_DEFAULT);
					
					mysqli_stmt_bind_param($stmt, "ssss", $cegnev, $kapcsolatnev, $email, $hashedPass);
					mysqli_stmt_execute($stmt);
						header("Location: index.html?succes=registered");
						header("Location: index.html");
						exit();
				}	
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>
<?php

if (isset($_POST['submit'])){

	require 'database.php';

	$email 		= $_POST['email'];
	$password 	= $_POST['password'];

	if (empty($email) || empty($password)){//üres mezők ellenőrzése
		header("Location: index.html?error=emptyfields&email=".$email);
		exit();
		} else {
				$sql = "SELECT * FROM ugyfel WHERE email = ?";
				$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)){//sql hiba esetén
						header("Location: index.html?error=sqlerror");
						exit();
						} else {
								mysqli_stmt_bind_param($stmt, "s", $email);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);

								if ($row = mysqli_fetch_assoc($result)){
									$passCheck = password_verify($password, $row['password']);
									if($passCheck == false){ //jelszó hamis
										header("Location: index.html?error=wrongpass1&password=".$row['password']);
										exit();
										} elseif ($passCheck == true){ //jelszó igaz
											session_start();
											$_SESSION['sessionemail'] = $row['email'];
											$_SESSION['sessioncegnev'] = $row['cegnev'];
											$_SESSION['sessionid'] = $row['id'];
											header("Location: index.php?ugyfelid=".$row['id']." ");
											exit();
											} else {
												header("Location: index.html?error=wrongpass ");
												exit();
												}
			} else {//nem létező user
				header("Location: index.html?error=nouser");
				exit();
				}
		}
	}
	
} else {
	header("Location: index.html?error=accessforbidden");
	exit();
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
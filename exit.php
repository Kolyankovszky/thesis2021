<?php
require 'database.php';
session_start();

if (!$conn){
	die("Database connection failed!". mysqli_connect_error());
	}
	$sql = "DELETE FROM aeta, aetp, aetu USING aeta INNER JOIN aetp INNER JOIN aetu";
	$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql))
		{
		header("Location: index.html?error=$cikkszam");
		exit();
		}else{
			mysqli_stmt_bind_param($stmt, "s", $cikkszam);
			mysqli_stmt_execute($stmt);
			header("Location: index.html?succes=deleted");
				}	
		mysqli_stmt_close($stmt);
	mysqli_close($conn);
	
session_unset();
session_destroy();
ob_end_clean();
header("Location: index.html");
exit();
?>
<?php
	require 'database.php';
	session_start();
	ob_start();
	
		if (!$conn){
			die("Database connection failed!". mysqli_connect_error());
			}	
			$sql = "SELECT aetu.ugyfelid,aetp.szivid,aeta.cikkszam FROM `aetu`,`aetp`,`aeta`";
			$result = mysqli_query($conn, $sql);
				while ($row=mysqli_fetch_assoc($result))
				{
					$ugyfelid = 'ugyfelid';
					$szivid = 'szivid';
					$cikkszam = 'cikkszam';						
				}
		
		 
			
				$sql = "INSERT INTO ajanlatgyujto(ugyfelid,szivid,cikkszam) SELECT aeta.cikkszam,aetp.szivid,aetu.ugyfelid FROM aeta,aetp,aetu";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql))
				{
					header("Location: ajanlat.php?error=ugyfelid");
					exit();
				}
				else
				{
					mysqli_stmt_bind_param($stmt, "sss", $ugyfelid,$szivid,$cikkszam);
					mysqli_stmt_execute($stmt);
					header("Location: ajanlat.php?succes=ajánlatregisztráció");
					exit();
				}	
			
			mysqli_stmt_close($stmt);
		mysqli_close($conn);

?>
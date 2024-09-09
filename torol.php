<?php
session_start();//session indítása
require 'database.php';//adatbázis indítása
if (isset($_GET['cikkszam']))
{
	$cikkszam = $_GET['cikkszam'];
	$sql = "SELECT id FROM aeta WHERE cikkszam = ?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql))
	{
		header("Location: ajanlat.php?error=sqlerror1");
		exit();
	} else
		{
			$sql = "DELETE FROM aeta WHERE aeta.cikkszam = $cikkszam";
			$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql))
				{
				header("Location: ajanlat.php?error=$cikkszam");
				exit();
				}
				else
				{
				mysqli_stmt_bind_param($stmt, "s", $cikkszam);
				mysqli_stmt_execute($stmt);
				header("Location: ajanlat.php?succes=deleted");
				exit();
				}	
			}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>

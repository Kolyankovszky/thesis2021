<?php
	require 'database.php';
	session_start();
	ob_start();
	if (isset($_GET['ugyfelid']))
	{
		$ugyfelid = $_GET['ugyfelid'];
		$sql = "SELECT id FROM aetu WHERE ugyfelid = ?";
		$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql))
	{
		header("Location: index.php?error=sqlerror1");
		exit();
	} else
		{
			$sql = "INSERT INTO aetu (ugyfelid) VALUES ($ugyfelid)";
			$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql))
				{
				header("Location: index.php?error=$ugyfelid");
				exit();
				}
				else
				{
				mysqli_stmt_bind_param($stmt, "s", $ugyfelid);
				mysqli_stmt_execute($stmt);
				header("Location: index.php?succes=registerugyfelid");
				exit();
				}	
			}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Szivattyú alkatrészek</title>
	<link rel="stylesheet" type="text/css" media="all" href="style.css">
</head>

<body>

	<header>
		<div style="text-align: left">SZIVATTYÚ ALKATRÉSZEK</div>
	</header>

	<ul>
	  <li><a class="active" href="#home">						Home	</a></li>
	  <li><a href="#news">										News	</a></li>
	  <li><a href="#contact">									Contact	</a></li>
	  <li><a href="#about">										About	</a></li>
	  <li style="float:right"><a class="active" href="exit.php">Kilépés	</a></li>
	</ul>

	<div style="padding:20px;margin-top:60px;background-color:antracit;height:1500px;">

		<div class="container">

		  <form action="productregister-inc.php" method="post">
		  
				<h3>Szivattyú regisztráció:</h3>
		  
				<div class="row">
					<div class="col-25">
						<label for="pumpmarka">Márka</label>
					</div>
					<div class="col-75">
						<select id="pumpmarka" name="pumpmarka">
							<option value="Sandpiper">Sandpiper</option>
							<option value="Waukesha">Waukesha</option>
							<option value="Viking">Viking</option>
						</select>	
					</div>
				</div>
		  
				<div class="row">
					<div class="col-25">
						<label for="pumpmodell">Modell szám</label>
					</div>
					<div class="col-75">
						<input type="text" name="pumpmodell" placeholder="például: U3">
					</div>
				</div>
				 
				 <div class="row">
					<div class="col-25">
						<label for="pumpsorozat">Sorozat szám</label>
					</div>
					<div class="col-75">
						<input type="text" name="pumpsorozat" placeholder="például: 030">
					</div>
				 </div>
				  
				 <div class="row">
					<div class="col-25">
						<label for="pumpgyariszam">Gyári szám</label>
					</div>
					<div class="col-75">
						<input type="text" name="pumpgyariszam" placeholder="például: 236559634">
					</div>
				 </div>
				 
				 <div class="row">
					<input type="submit" name="submit">
				 </div>
			</form>
		</div>
		

		<div style="background-color:silver; border-radius: 5px">
			<h2>Regisztrált szivattyúk</h2>

			<table>
				<tr>
					<th>Nr</th>
					<th>Márka</th>
					<th>Modell száma</th>
					<th>Sorozat száma</th>
					<th>Gyári száma</th>
					<th>Ügyfél azonosító</th>
					<th colspan=2><center>Művelet</th>
				</tr>

				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
							$ugyfelid = $_SESSION['sessionid'];
							$sql = "SELECT * FROM `szivattyuk` WHERE ugyfelid = $ugyfelid ";
							$result = mysqli_query($conn, $sql);
								while ($row=mysqli_fetch_assoc($result))
								{
									echo"<tr>
										<td>".$row["id"]			."</td>
										<td>".$row["pumpmarka"]		."</td>
										<td>".$row["pumpmodell"]	."</td>
										<td>".$row["pumpsorozat"]	."</td>
										<td>".$row["pumpgyariszam"]	."</td>
										<td>".$row["ugyfelid"]		."</td>
										<td><center>";
										echo"<a href=ajreg-inc.php?id=".$row['id']."> VÁLASZT </a></td>";
										echo"<td><a href=archiv.php?pumpgyariszam=".$row['pumpgyariszam']."> TÖRÖL </a></td>
									</tr>";
								}
			echo"</table>";
				?>
				
		</div>
		
		<div style="background-color:yellow; border-radius: 5px">
			<h2>Törölt szivattyúk</h2>

			<table>
				<tr>
					<th>Nr</th>
					<th>Márka</th>
					<th>Modell száma</th>
					<th>Sorozat száma</th>
					<th>Gyári száma</th>
					<th>Ügyfél azonosító</th>
					<th>Törlés dátuma</th>
					<th>Művelet</th>
				</tr>

				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
							$sql = "SELECT * FROM `arhsziv`";
							$result = mysqli_query($conn, $sql);
								while ($row=mysqli_fetch_assoc($result))
								{
									echo"<tr>
										<td>".$row["arhszivid"]	."</td>
										<td>".$row["arhpmark"]	."</td>
										<td>".$row["arhpmod"]	."</td>
										<td>".$row["arhpsor"]	."</td>
										<td>".$row["arhpgysz"]	."</td>
										<td>".$row["ugyfelid"]	."</td>
										<td>".$row["arhdate"]	."</td>";
										echo"<td><a href=arhsziv.php?arhpgysz=".$row['arhpgysz']."> HELYREÁLLÍT </a></td>
									</tr>";
								}
			echo"</table>";
					mysqli_close($conn);
				?>
				
		</div>
	</div>

	<footer>
		<?php
			if (isset($_SESSION['sessioncegnev']))
			{
				echo "BELÉPVE: " . $_SESSION['sessioncegnev'] ;
			}
			else 
			{
				echo " Nincs belépve! ";
			}
		?>
	</footer>

</body>
</html>
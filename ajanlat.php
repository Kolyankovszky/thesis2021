<?php
session_start();
require 'database.php';
?>

<!DOCTYPE html>

<html lang="hu">

<head>
	<meta = charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
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

	<div style="padding:20px;margin-top:100px;background-color:antracit;height:1000px;">

		<div class="container">

		  <form action="ajanlatemail.php">
		  
		  <h3>Ajánlatkérő adatai</h3>
		  
				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
						$ugyfelid = $_SESSION['sessionid'];
						if (empty($ugyfelid)){
							echo "Nincs bejelentkezve!<a href=index.html>Bejelentkezéshez!</a>";
							exit();
						}
						
						else{
						$sql = "SELECT * FROM `ugyfel` WHERE id=$ugyfelid";
						$result = mysqli_query($conn, $sql);
							while ($row=mysqli_fetch_assoc($result))
							{
								echo "Ügyfélszám: 			" . $row["id"] 				. "<br>";
								echo "Cégnév: 				" . $row["cegnev"] 			. "<br>";	
								echo "Kapcsolattartó neve: 	" . $row["kapcsolatnev"] 	. "<br>";
								echo "e-mail: 				" . $row["email"] 			. "<br>";
							}
						}
				?>

			<h3>Szivattyú adatok</h3>
			
				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
						$szivid = $_SESSION['sessionszivid'];
						$sql = "SELECT * FROM `szivattyuk` WHERE id = $szivid";
						$result = mysqli_query($conn, $sql);
							while ($row=mysqli_fetch_assoc($result))
								{
									echo "Márka:      " . $row["pumpmarka"] . "<br>";
									echo "Modell:     " . $row["pumpmodell"] . "<br>";
									echo "Sorozat:    " . $row["pumpsorozat"] . "<br>";
									echo "Gyári szám: " . $row["pumpgyariszam"] . "<br>";		
								}		
				?>
			<h3>Alkatrészek</h3>
			<table>
				<tr>
					
					<th>Rajz szám</th>
					<th>Leírás</th>
					<th>Cikk szám</th>
					<th>Megjegyzés</th>
					<th>Menny/sziv</th>
					<th>Művelet</th>
				</tr>

				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
						
						$sql = "SELECT alk.rajzszam,alk.leiras,alk.cikkszam,alk.megj,alk.szivmenny FROM alk,aeta WHERE aeta.cikkszam = alk.cikkszam";
						
						$result = mysqli_query($conn, $sql);
							while ($row=mysqli_fetch_assoc($result))
								{
									echo"<tr>
										<td>".$row["rajzszam"]	."</td>
										<td>".$row["leiras"]	."</td>
										<td>".$row["cikkszam"]	."</td>
										<td>".$row["megj"]		."</td>
										<td>".$row["szivmenny"]	."</td>";
										echo"<td><a href=torol.php?cikkszam=".$row['cikkszam']."> TÖRÖL </a></td>
										</tr>";
								}
									
									echo"</table>";
									echo"<br><center><a href=product.html>Alkatrész hozzáadása</a></center>";

				?>
				 <div class="row">
					<input type="submit" name="submit">
				 </div>
			</form>
		</div>
		
		<h1></h1>
		
		<div class="container" style="width:100%">
			<form>
				<h3>Elküldött ajánlatkérések</h3>
				<table>
					<tr>
						<th>Dátum</th>
						<th>Ajánlatkérés szám</th>
						<th>Márka</th>
						<th>Modell</th>
						<th>Sorozatszám</th>
						<th>Gyáriszám</th>
						<th>Rajz szám</th>
						<th>Leírás</th>
						<th>Cikk szám</th>
						<th>Megjegyzés</th>
						<th>Menny/sziv</th>
						<th>Művelet</th>
					</tr>
				
					<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
						
						$sql = "SELECT ajanlatgyujto.datum,ajanlatgyujto.ajanlatszam,szivattyuk.pumpmarka,szivattyuk.pumpmodell,szivattyuk.pumpsorozat,szivattyuk.pumpgyariszam,alk.rajzszam,alk.leiras,alk.cikkszam,alk.megj,alk.szivmenny FROM ajanlatgyujto,szivattyuk,alk";
						
						$result = mysqli_query($conn, $sql);
							while ($row=mysqli_fetch_assoc($result))
								{
									echo"<tr>
										<td>".$row["datum"]			."</td>
										<td>".$row["ajanlatszam"]	."</td>
										<td>".$row["pumpmarka"]		."</td>
										<td>".$row["pumpmodell"]	."</td>
										<td>".$row["pumpsorozat"]	."</td>
										<td>".$row["pumpgyariszam"]	."</td>
										<td>".$row["rajzszam"]		."</td>
										<td>".$row["leiras"]		."</td>
										<td>".$row["cikkszam"]		."</td>
										<td>".$row["megj"]			."</td>
										<td>".$row["szivmenny"]		."</td>";
										echo"<td><a href=torol.php?cikkszam=".$row['cikkszam']."> FELVESZ </a></td>
										</tr>";
								}
			echo"</table>";
					echo"<br><center><a href=ajanlat.php>Lista vége, vissza a lap tetejére.</a></center>";
				?>
			</form>
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
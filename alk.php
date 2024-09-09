<?php
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
	  <li style="float:right"><a class="active" href="#belepes">Belépés	</a></li>
	</ul>

	<div style="padding:20px;margin-top:60px;background-color:antracit;height:1500px;">

		<div class="container">

		  <form action="alk-inc.php" method="post">
		  
				<h3>Szivattyú alkatrész rögzítés:</h3>
		  
				<div class="row">
					<div class="col-25">
						<label for="rajzszam">Rajzszám</label>
					</div>
					<div class="col-75">
						<input type="text" name="rajzszam" placeholder="például: 26A">
					</div>
				</div>
		  
				<div class="row">
					<div class="col-25">
						<label for="leiras">Leírás</label>
					</div>
					<div class="col-75">
						<input type="text" name="leiras" placeholder="például: Szivattyúház">
					</div>
				</div>
				 
				 <div class="row">
					<div class="col-25">
						<label for="szivmenny">Menny / szivattyú</label>
					</div>
					<div class="col-75">
						<input type="text" name="szivmenny" placeholder="például: 1">
					</div>
				 </div>
				  
				 <div class="row">
					<div class="col-25">
						<label for="cikkszam">Cikk szám</label>
					</div>
					<div class="col-75">
						<input type="text" name="cikkszam" placeholder="például: E236559634">
					</div>
				 </div>
				 
				 <div class="row">
					<div class="col-25">
						<label for="megj">Megjegyzés</label>
					</div>
					<div class="col-75">
						<input type="text" name="megj" placeholder="kiegészítő szövegre utaló szám: 43">
					</div>
				 </div>
				 
				 <div class="row">
					<input type="submit" name="submit">
				 </div>
			</form>
		</div>
		

		<div style="background-color:silver; border-radius: 5px">
			<h2>Regisztrált alkatrészek</h2>

			<table>
				<tr>
					<th>Nr</th>
					<th>Rajzszám</th>
					<th>Leírás</th>
					<th>Mennyiség szivattyúnként</th>
					<th>Cikk szám</th>
					<th>Megjegyzés</th>
					<th colspan=2><center>Művelet</th>
				</tr>

				<?php
					if (!$conn){
						die("Database connection failed!". mysqli_connect_error());
						}
							$sql = "SELECT * FROM `alk`";
							$result = mysqli_query($conn, $sql);
								while ($row=mysqli_fetch_assoc($result))
								{
									echo"<tr>
										<td>".$row["alkid"]			."</td>
										<td>".$row["rajzszam"]		."</td>
										<td>".$row["leiras"]	."</td>
										<td>".$row["szivmenny"]	."</td>
										<td>".$row["cikkszam"]	."</td>
										<td>".$row["megj"]	."</td>
										<td><center>";
										echo"<a href=alk.php?alkid=".$row['alkid']."> SZERKESZT </a></td>";
										echo"<td><a href=archiv.php?alkid=".$row['alkid']."> TÖRÖL </a></td>
									</tr>";
								}
			echo"</table>";
					mysqli_close($conn);
				?>
				
		</div>
	</div>

	<footer>
		Nincs belépve!
	</footer>

</body>
</html>
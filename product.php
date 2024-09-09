<!DOCTYPE html>

<html lang="hu">


	<?php
		require 'database.php';
	?>

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

		<div style="background-color:silver; border-radius: 5px">
			<h2>Kiválasztott szivattyú</h2>

			<table>
				<tr>
					<th>Nr</th>
					<th>Márka</th>
					<th>Modell száma</th>
					<th>Sorozat száma</th>
					<th>Gyári száma</th>
				</tr>

				<?php
					if(!isset($_GET['id'])){
						echo "Hiba történt! <a href=index.php>Vissza a főoldalra!</a><br>";
					}else{$id=$_GET['id'];
						$sql="SELECT * FROM `szivattyuk` WHERE id=$id";
						$result=mysqli_query($conn, $sql);
						while($row=mysqli_fetch_assoc($result)){
							echo"<tr>
							<td>".$row["id"]."</td>
							<td>".$row["pumpmarka"]."</td>
							<td>".$row["pumpmodell"]."</td>
							<td>".$row["pumpsorozat"]."</td>
							<td>".$row["pumpgyariszam"]."</td>
							</tr>";
						}
						echo"</table></center>";
						mysqli_close($conn);
						}
				?>
			<img src="waukesha.png" alt="waukesha" usemap="#workmap" width="1200" height="900">
			<map name="workmap">
			<area shape="circle" coords="337, 300, 300">
		</div>
	</div>

	<footer>
		Nincs belépve!
	</footer>

</body>
</html>
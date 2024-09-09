<?php

//Params to connect to a database
$dbHost="localhost";
$dbUser="root";
$dbPass="";
$dbName="projecttwo";

//Connection to database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

//Check connection
if (!$conn){
	die("Database connection failed!". mysqli_connect_error());
}
echo "Connected Successfully";
?>
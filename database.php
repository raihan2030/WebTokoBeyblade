<?php

$hostname = "localhost";
$username = "root";
$password = "";
$db_name =  "database_beyblade";

try {
   $conn = new PDO("mysql:host=$hostname; dbname=$db_name", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
   exit();
}
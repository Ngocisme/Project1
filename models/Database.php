<?php

// include_once "../config.php";
$servername = "localhost";
$username = "mamp";
$password = "";
$database = "KeiTaiZonePHP";

function check($check){
  echo "<pre>";
  print_r($check);
  echo "</pre>";
}
function formatCurrencyVND($amount) {
  return number_format($amount, 0, ',', '.') . ' VND';
}

/// Check Database connect
try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
<?php
$host = 'localhost'; // o la dirección IP del servidor
$dbname = 'importCars';
$username = 'postgres';
$password = '123';

try {
  $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
  echo "Conexión exitosa";
} catch (PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}
?>
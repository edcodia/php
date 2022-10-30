<?php 
$nomeServidor = "localhost";
$nomeUtilizador = "root";
$password = "";
$nomeBD = "criar_bd";

// ligar à base de dados
$db = mysqli_connect($nomeServidor, $nomeUtilizador, $password, $nomeBD);

// Verificar ligação
if (!$db) {
	die("Connection failed: " . mysqli_connect_error());
  }

?>
<?php
try {
	$dsn = 'mysql:host=banco;dbname=lash_design;charset=utf8mb4';
	$user = 'root';
	$pass = '';
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	$conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
	die('Erro na conexão: ' . $e->getMessage());
}


<?php
$conexao = new mysqli(
	'banco',
	'root',
	'root',
	'project_pw3crud'
);

if ($conexao->connect_error) {
	die('Erro na conexão: ' . $conexao->connect_error);
}


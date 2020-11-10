<?php 




include_once("../config.php");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
date_default_timezone_set('America/Sao_Paulo');


try {
	$pdo = new PDO("mysql:dbname=$banco;host=$host;charset=utf8", "$usuario", "$senha");

} catch (Exception $e) {
	echo "Erro ao conectar com o banco de dados! ".$e;
}



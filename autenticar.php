<?php

require_once("conexao.php");
@session_start();

if (empty($_POST['username']) || empty($_POST['pass'])) {
	echo "<script language='javascript'>window.location='login.php'; </script>";
}

$usuario = $_POST['username'];
$senha = $_POST['pass'];

/*echo "Senha";
echo $senha;*/

$senhaNew = base64_encode($senha);

/*echo "Senha nova";
echo $senhaNew;/*


/*$senhaNew = base64_decode($senha);
echo "Senha nova";
echo $senhaNew;*/
$res = $pdo->prepare("SELECT * from usuarios where usuario = :usuario and senha = :senha ");

$res->bindValue(":usuario", $usuario);
$res->bindValue(":senha", $senhaNew);
$res->execute();

$dados = $res->fetchAll(PDO::FETCH_ASSOC);


$linhas = count($dados);



if ($linhas > 0) {
	$_SESSION['nome_usuario'] = $dados[0]['nome'];
	$_SESSION['email_usuario'] = $dados[0]['usuario'];
	$_SESSION['nivel_usuario'] = $dados[0]['nivel'];
	$_SESSION['cpf_usuario'] = $dados[0]['cpf'];

	if ($_SESSION['nivel_usuario'] == 'Admin') {
		echo "<script language='javascript'>window.location='painel-adm/index.php'; </script>";
		exit();
	}

	if ($_SESSION['nivel_usuario'] == 'Cliente') {
		echo "<script language='javascript'>window.location='produtos'; </script>";
		exit();
	}

	if ($_SESSION['nivel_usuario'] == 'Balconista') {
		echo "<script language='javascript'>window.location='painel-balcao/index.php'; </script>";
		exit();
	}
} else {
	echo "<script language='javascript'>window.alert('Dados Incorretos!!'); </script>";
	echo "<script language='javascript'>window.location='login.php'; </script>";
}

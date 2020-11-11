<?php 

$email_adm = 'admin';
$url_site = 'http://localhost:8080/';
$nome_loja = 'Freitas Delivery';

/*
//DADOS PARA CONEXÃO COM BD LOCAL
$banco = 'delivery';
$host = 'localhost';
$usuario = 'root';
$senha = '';
*/


$banco = 'delivery';
$host = 'localhost';
$usuario = 'root';
$senha = '';


//CONFIGURAÇÕES PARA PAGINAÇÃO DE ITENS NO PAINEL
//Valor padrão para as paginações
$itens_por_pagina = 5;
$itens_por_pagina_produtos = 20;

//valor que o usuario pode alterar para mostrar a paginação
$itens_por_pagina_1 = 5;
$itens_por_pagina_2 = 10;
$itens_por_pagina_3 = 20;

//Token de Api do google

define("GOOGLE",[
        'clientId'     => '78022928929-8kb3741ufeqm6lri1fa2d0pqmk0crqnn.apps.googleusercontent.com',
        'clientSecret' => 'JGWzlYBWt0ntCNS8RAqKc74f',
        'redirectUri'  => 'http://localhost/ProjetoDelivery/'
]);

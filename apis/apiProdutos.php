<?php

include_once('conexao.php');

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'listar-produtos'){

	$id_cat = $postjson['id_cat'];
  $buscar = '%'.$postjson['buscar'].'%';

	if($id_cat > 0){
		 $query = $pdo->query("SELECT * from produtos where categoria = '$id_cat' order by vendas desc limit $postjson[start], $postjson[limit]");
	}else if($id_cat == 'adc'){
     $query = $pdo->query("SELECT * from produtos where adicional = 'Sim' order by vendas desc limit $postjson[start], $postjson[limit]");
  }else{
		 $query = $pdo->query("SELECT * from produtos where adicional is null and (nome LIKE '$buscar' or descricao LIKE '$buscar' or descricao_longa LIKE '$buscar') order by vendas desc limit $postjson[start], $postjson[limit]");
	}

   
   
   
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total = count($res);


  $dados;
  if($total > 0){

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
 			$dados[] = array(
 			'id' => $res[$i]['id'],
 			'nome' => $res[$i]['nome'],
 			'descricao' => $res[$i]['descricao'],
			'valor' => $res[$i]['valor'],
      		'imagem' => $res[$i]['imagem'],
            
            
        
 		);

 }

 }

        if(count($res) > 0){
                 $result = json_encode(array('success'=>true, 'result'=>$dados, 'total'=>$total));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;





}else if($postjson['requisicao'] == 'listar-cat'){

    $query = $pdo->query("SELECT * from categorias order by produtos desc limit $postjson[start], $postjson[limit]");
   
   
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total = count($res);

 	for ($i=0; $i < count($res); $i++) { 
      foreach ($res[$i] as $key => $value) {
      }
 			$dados[] = array(
 			'id' => $res[$i]['id'],
 			'nome' => $res[$i]['nome'],
 			'descricao' => $res[$i]['descricao'],
			'produtos' => $res[$i]['produtos'],
      		'imagem' => $res[$i]['imagem'],

            
            
        
 		);

 }

        if(count($res) > 0){
                $result = json_encode(array('success'=>true, 'result'=>$dados, 'total'=>$total));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;





}else if($postjson['requisicao'] == 'add-carrinho'){

$id_produto = $postjson['id_produto'];
$cpf_cliente = $postjson['cpf'];


//VERIRICAR SE O PRODUTO JÁ EXISTE NO CARRINHO
$res_p = $pdo->query("SELECT * from carrinho where id_produto = '$id_produto' and id_venda = 0 and cpf = '$cpf_cliente' ");
$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
$linhas_p = count($dados_p);
if($linhas_p > 0){
  $quant_p = $dados_p[0]['quantidade'];
  $quant_p = $quant_p + 1;

  $res = $pdo->query("UPDATE carrinho set quantidade = '$quant_p' where id_produto = '$id_produto' and cpf = '$cpf_cliente'");
 $result = json_encode(array('success'=>true));
 echo $result;

  exit();


}


if($cpf_cliente != ''){


$quantidade = 1;

$res = $pdo->query("INSERT into carrinho (id_venda, id_produto, cpf, quantidade) values ('0', '$id_produto', '$cpf_cliente', '$quantidade')");

  
} 


  
      if(count($res) > 0){
        $result = json_encode(array('success'=>true));


        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;





   }else if($postjson['requisicao'] == 'listar-carrinho'){

     $cpf_usuario = $postjson['cpf'];
     $res = $pdo->query("SELECT * from carrinho where cpf = '$cpf_usuario' and id_venda = 0 and quantidade > 0 order by id asc");
     $dados = $res->fetchAll(PDO::FETCH_ASSOC);
     $linhas = count($dados);

   if($linhas == 0){
      $linhas = 0;
      $total = 0;
    }

    $total = 0;
    for ($i=0; $i < count($dados); $i++) { 
      foreach ($dados[$i] as $key => $value) {
      }

      $id_produto = $dados[$i]['id_produto']; 
      $quantidade = $dados[$i]['quantidade'];
      $id_carrinho = $dados[$i]['id'];


      $res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
      $dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
      $nome_produto = $dados_p[0]['nome'];  
      $valor = $dados_p[0]['valor'];
      $imagem = $dados_p[0]['imagem'];
      $adicional = $dados_p[0]['adicional'];


      $total_item = $valor * $quantidade;
      @$total = @$total + $total_item;


      $valor = number_format( $valor , 2, ',', '.');
                            //$total = number_format( $total , 2, ',', '.');
      $total_item = number_format( $total_item , 2, ',', '.');


      //recuperar valor do frete
      $res_f = $pdo->query("SELECT * from config where id = 1 ");
      $dados_f = $res_f->fetchAll(PDO::FETCH_ASSOC);
      $frete = $dados_f[0]['taxa_entrega'];  
      $previsao = $dados_f[0]['previsao_minutos'];



      $subtotal = @$total + $frete;
      $subtotal2 = number_format( $subtotal , 2, ',', '.');

       $dados_carrinho[] = array(
      'id' => $id_produto,
      'quantidade' => $quantidade,
      'valor' =>  $valor,
      'imagem' => $imagem,
      'nome' => $nome_produto,
      'adicional' => $adicional,         
       );

    }




    
    $total_final = number_format( $total , 2, ',', '.');
    
    $result = json_encode(array('success'=>true, 'result'=>$dados_carrinho, 'total'=>$total_final, 'frete'=>$frete, 'subtotal'=>$subtotal, 'subtotal2'=>$subtotal2, 'totalItens'=>$linhas, 'previsao'=>$previsao));

     echo $result;





}else if($postjson['requisicao'] == 'add-item'){

$id = $postjson['id'];
$cpf_cliente = $postjson['cpf'];


//VERIRICAR SE O PRODUTO JÁ EXISTE NO CARRINHO
$res_p = $pdo->query("SELECT * from carrinho where id_produto = '$id' and id_venda = 0 and cpf = '$cpf_cliente' ");
$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
$quant = $dados_p[0]['quantidade'];
$quant = $quant + 1;



$res = $pdo->query("UPDATE carrinho set quantidade = '$quant' where id_produto = '$id' and id_venda = 0 and cpf = '$cpf_cliente' ");



  
      if(count($res) > 0){
        $result = json_encode(array('success'=>true));


        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;


  }else if($postjson['requisicao'] == 'remove-item'){

$id = $postjson['id'];
$cpf_cliente = $postjson['cpf'];


//VERIRICAR SE O PRODUTO JÁ EXISTE NO CARRINHO
$res_p = $pdo->query("SELECT * from carrinho where id_produto = '$id' and id_venda = 0 and cpf = '$cpf_cliente' ");
$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
$quant = $dados_p[0]['quantidade'];
$quant = $quant - 1;



$res = $pdo->query("UPDATE carrinho set quantidade = '$quant' where id_produto = '$id' and id_venda = 0 and cpf = '$cpf_cliente' ");



  
      if(count($res) > 0){
        $result = json_encode(array('success'=>true));


        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;






  }else if($postjson['requisicao'] == 'listar-clientes'){

  $cpf = $postjson['cpf'];

  
     $query = $pdo->query("SELECT * from clientes where cpf  = '$cpf' ");
  
   
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $nome = $res[0]['nome'];
    $rua = $res[0]['rua'];
    $numero = $res[0]['numero'];
    $bairro = $res[0]['bairro'];

  

        if(count($res) > 0){
                 $result = json_encode(array('success'=>true, 'rua'=>$rua, 'numero'=>$numero, 'bairro'=>$bairro));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;





}else if($postjson['requisicao'] == 'finalizar-pedido'){


$tipo = $postjson['tipo'];
$rua = $postjson['rua'];
$numero = $postjson['numero'];
$bairro = $postjson['bairro'];

$obs = $postjson['obs'];
$total = $postjson['total'];
$cpf_cliente = $postjson['cpf'];
$total_pago = $postjson['troco'];

if ($total_pago == ''){
  $total_pago = 0;
}




if($tipo == ''){
  $texto = 'Preencha o Tipo de Pagamento';
  $result = json_encode(array('success'=>true, 'texto'=>$texto));
  echo $result;
  exit();
}


if($total_pago != ''){
  
  $troco = $total_pago - $total;

  if($troco < 0){
    $texto = "O valor a pagar não pode ser menor que o valor total da compra!!";
    $result = json_encode(array('success'=>true, 'texto'=>$texto));
    echo $result;
    exit();
  }
}else{
  $troco = 0;
}


if($cpf_cliente != ''){


$res = $pdo->prepare("INSERT into vendas (cliente, total, total_pago, troco, tipo_pgto, data, hora, status, pago, obs) values (:cliente, :total, :total_pago, :troco, :tipo_pgto, curDate(), curTime(), :status, :pago, :obs)");

$res->bindValue(":cliente", $cpf_cliente);
$res->bindValue(":total", $total);
$res->bindValue(":total_pago", $total_pago);
$res->bindValue(":troco", $troco);
$res->bindValue(":tipo_pgto", $tipo);
$res->bindValue(":status", 'Iniciado');
$res->bindValue(":pago", 'Não');
$res->bindValue(":obs", $obs);

$res->execute();
$id_venda = $pdo->lastInsertId();
  
} 




//TRAZER O TOTAL DE CARTÕES QUE O CLIENTE TEM
$res = $pdo->query("SELECT * from clientes where cpf = '$cpf_cliente'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$cartoes = $dados[0]['cartao'];
$cartoes = $cartoes + 1;

//ATUALIZAR OS DADOS DE ENDEREÇO DO CLIENTE
$res = $pdo->prepare("UPDATE clientes SET rua = :rua, numero = :numero, bairro = :bairro, cartao = :cartao where cpf = '$cpf_cliente'");

$res->bindValue(":rua", $rua);
$res->bindValue(":numero", $numero);
$res->bindValue(":bairro", $bairro);
$res->bindValue(":cartao", $cartoes);

$res->execute();



//INCREMENTAR UMA VENDA NOS PRODUTOS VENDIDOS
$res = $pdo->query("SELECT * from carrinho where id_venda = 0 and cpf = '$cpf_cliente'");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i < count($dados); $i++) { 
      foreach ($dados[$i] as $key => $value) {
      }

      $id_produto = $dados[$i]['id_produto']; 
      $quant = $dados[$i]['quantidade'];  
      
      //BUSCAR O PRODUTO NA TABELA PRODUTOS PARA ATUALIZAR VENDA
      $res_p = $pdo->query("SELECT * from produtos where id = '$id_produto'");
      $dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
      $vendas_p = $dados_p[0]['vendas'];
      $vendas_p = $vendas_p + $quant;

      $pdo->query("UPDATE produtos set vendas = '$vendas_p' where id = '$id_produto'"); 

}




//ATUALIZAR O ID DA VENDA DOS ITENS DA TABELA CARRINHO PARA NOVA VENDA
$pdo->query("UPDATE carrinho SET id_venda = '$id_venda' where id_venda = 0 and cpf = '$cpf_cliente'");  




      $texto = 'Pedido Concluído!';
      if(count($res) > 0){
        $result = json_encode(array('success'=>true, 'texto'=>$texto));


        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;






  }else if($postjson['requisicao'] == 'remover-item-carrinho'){

$id = $postjson['id'];
$cpf_cliente = $postjson['cpf'];


$res = $pdo->query("DELETE from carrinho where id_produto = '$id' and id_venda = 0 and cpf = '$cpf_cliente' ");



  
      if(count($res) > 0){
        $result = json_encode(array('success'=>true));


        }else{
        $result = json_encode(array('success'=>false));
    
        }
     echo $result;





}




?>
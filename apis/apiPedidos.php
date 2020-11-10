<?php

include_once('conexao.php');


$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['requisicao'] == 'listar'){

	$cpf = $postjson['cpf'];
  $data = $postjson['nome'];

    
    if($data == ""){
      $res = $pdo->query("SELECT * from vendas where cliente = '$cpf' order by id desc LIMIT 10");
  
    }else{
      $res = $pdo->query("SELECT * from vendas where cliente = '$cpf' and data = '$data' order by id desc");
  
    }
    
  
  
  
  $dados = $res->fetchAll(PDO::FETCH_ASSOC);


    for ($i=0; $i < count($dados); $i++) { 
      foreach ($dados[$i] as $key => $value) {
      }

      $id = $dados[$i]['id']; 
      $hora = $dados[$i]['hora'];
      $total = $dados[$i]['total'];
      $tipo_pgto = $dados[$i]['tipo_pgto'];
      $status = $dados[$i]['status'];
      $pago = $dados[$i]['pago'];
      $data = $dados[$i]['data'];
      $data2 = implode('/', array_reverse(explode('-', $data)));

       //recuperar TEMPO ESTIMADO PARA ENTREGA
      $res_f = $pdo->query("SELECT * from config where id = 1 ");
      $dados_f = $res_f->fetchAll(PDO::FETCH_ASSOC);
      $frete = $dados_f[0]['taxa_entrega'];  
      $previsao = $dados_f[0]['previsao_minutos'];

      $previsao = date("H:i",strtotime("$hora + $previsao minutes"));
    


      $dado[] = array(
      'id' => $id,
      'hora' => $previsao,
      'total' => $total,
      'tipo_pgto' => $tipo_pgto,
      'status' => $status,
      'pago' => $pago,
      'data' => $data2,
            
            
        
    );

	

    
    }

 
    
        if(count($res) > 0){
                 $result = json_encode(array('success'=>true, 'result'=>$dado));

            }else{
                $result = json_encode(array('success'=>false, 'result'=>'0'));

            }
            echo $result;





}else if($postjson['requisicao'] == 'listar-produtos'){

     $id = $postjson['id'];
     $res = $pdo->query("SELECT * from carrinho where id_venda = '$id' order by id asc");
            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
            $linhas = count($dados);
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
              $total_item = $valor * $quantidade;
              $total_item = number_format( $total_item , 2, ',', '.');




       $dados_carrinho[] = array(
      'id' => $id_produto,
      'quantidade' => $quantidade,
      'valor' =>  $total_item,
      'imagem' => $imagem,
      'nome' => $nome_produto,
                
       );

    }


  
    
    $result = json_encode(array('success'=>true, 'result'=>$dados_carrinho));

     echo $result;





}else if($postjson['requisicao'] == 'listar-cartoes'){

    $cpf = $postjson['cpf'];
    
    $res_todos = $pdo->query("SELECT * from clientes where cpf = '$cpf'");
    $dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
    $carimbos = $dados_total[0]['cartao'];

    $result = json_encode(array('success'=>true, 'cartao'=>$carimbos));

     echo $result;


}





?>
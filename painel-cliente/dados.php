<?php

@session_start();
include_once('../conexao.php');

if (@$_GET['funcao'] == 'editar') {

    //TRAZER OS DADOS DO CLIENTE
    $cpf_cliente = @$_SESSION['cpf_usuario'];
    $res = $pdo->query("SELECT * from clientes where cpf = '$cpf_cliente'");
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $nome = @$dados[0]['nome'];
    $telefone = @$dados[0]['telefone'];
    $email = @$dados[0]['email'];
    $rua = @$dados[0]['rua'];
    $numero = @$dados[0]['numero'];
    $bairro = @$dados[0]['bairro'];
    $cidade = @$dados[0]['cidade'];
    $estado = @$dados[0]['estado'];
    $cep = @$dados[0]['cep'];


    $res2 = $pdo->query("SELECT * from usuarios where cpf = '$cpf_cliente'");
    $dados2 = $res2->fetchAll(PDO::FETCH_ASSOC);
    $senha = @$dados2[0]['senha'];
}
?>
<h1>Editar Dados</h1>


<div class="modal-body">
          <form method="post">
            <div class="row">
              <div class="col-md-4">
               <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Nome</label>
                <input type="text" class="form-control form-control-sm" id="nome" name="nome" placeholder="Nome e Sobrenome" required value="<?php echo @$nome ?>">

              </div>
            </div>

            <div class="col-md-4">
             <div class="form-group">
              <label class="text-dark" for="exampleInputEmail1">CPF</label>
              <input type="text" class="form-control form-control-sm" id="cpf" name="cpf" placeholder="CPF" disabled value="<?php echo @$cpf_cliente ?>">

            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label class="text-dark" for="exampleInputEmail1">Telefone</label>
              <input type="text" class="form-control form-control-sm" id="telefone" name="telefone" placeholder="Telefone" required value="<?php echo @$telefone ?>">

            </div>

          </div>

         

      
         <div class="col-md-3">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required value="<?php echo @$email ?>">

          </div>

        </div>


          <div class="col-md-3">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Senha</label>
            <input type="senha" class="form-control form-control-sm" id="senha" name="senha" placeholder="Senha" required value="<?php echo @$senha ?>">

          </div>

        </div>

        <div class="col-md-4">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Rua</label>
            <input type="text" class="form-control form-control-sm" id="rua" name="rua" placeholder="Rua" required value="<?php echo @$rua ?>">

          </div>

        </div>


          <div class="col-md-2">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Número</label>
            <input type="text" class="form-control form-control-sm" id="numero" name="numero" placeholder="Número" required value="<?php echo @$numero ?>">

          </div>

        </div>

          <div class="col-md-3">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Bairro</label>
            
            <?php 
                //SE EXISTIR EDIÇÃO DOS DADOS, TRAZER O NOME DO ITEM ASSOCIADA AO REGISTRO
                if(@$bairro != ''){

                 
                  echo '<option value="'.@$bairro.'">'.@$bairro.'</option>';
                }else{
                   echo '<option value="">Selecione um Bairro</option>';
                }
                
             
                //TRAZER TODOS OS REGISTROS EXISTENTES
                $res = $pdo->query("SELECT * from locais order by nome asc");
                $dados = $res->fetchAll(PDO::FETCH_ASSOC);
             
                for ($i=0; $i < count($dados); $i++) { 
                  foreach ($dados[$i] as $key => $value) {
                  }
              
                  $id_item = $dados[$i]['id'];  
                  $nome_item = $dados[$i]['nome'];

               
                  if($nome_dado != $nome_item){
                    echo '<option value="'.$nome_item.'">'.$nome_item.'</option>';
                  }

                  
                }
                ?>

          </div>

        </div>

         <div class="col-md-4">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Cidade</label>
            <input type="text" class="form-control form-control-sm" id="cidade" name="cidade" placeholder="Cidade" required value="<?php echo @$cidade ?>">

          </div>

        </div>


          <div class="col-md-2">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">Estado</label>
           
            <select id="estado" name="estado" class="form-control form-control-sm">

        
      
         <option value="MG" <?php if($estado == 'MG'){ ?> selected <?php } ?>>MG</option>
        

      </select>

          </div>

        </div>


         <div class="col-md-3">
           <div class="form-group">
            <label class="text-dark" for="exampleInputEmail1">CEP</label>
            <input type="text" class="form-control form-control-sm" id="cep" name="cep" placeholder="CEP" required value="<?php echo @$cep ?>">

          </div>

        </div>



      </div>







      <div align="center" class="" id="mensagem">
      </div>


    </div>
    <div class="modal-footer">
     <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
     <button name="btn-editar" id="btn-editar" class="btn btn-info">Editar</button>

   </form>



   <?php if(isset($_POST['btn-editar'])){



$cpf = @$_SESSION['cpf_usuario'];
$nome = $_POST['nome'];
$email = $_POST['email'];

$telefone = $_POST['telefone'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$senha = $_POST['senha'];



$res = $pdo->prepare("UPDATE usuarios set nome = :nome, usuario = :usuario, senha = :senha, telefone = :telefone where cpf = :cpf");

    $res->bindValue(":nome", $nome);
    $res->bindValue(":usuario", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
   
    $res->bindValue(":telefone", $telefone);

    $res->execute();

    


   $res = $pdo->prepare("UPDATE clientes set nome = :nome, email = :usuario, rua = :rua, telefone = :telefone, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep where cpf = :cpf");

    $res->bindValue(":nome", $nome);
    $res->bindValue(":usuario", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":rua", $rua);
    $res->bindValue(":numero", $numero);
    $res->bindValue(":telefone", $telefone);
    $res->bindValue(":bairro", $bairro);
    $res->bindValue(":cidade", $cidade);
    $res->bindValue(":estado", $estado);
    $res->bindValue(":cep", $cep);

    $res->execute();

    echo "<script language='javascript'>window.location='produtos'; </script>";


} ?>
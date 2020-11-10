<?php

include_once("conexao.php");

if (isset($_POST['email2']) and $_POST['email2'] != '') {
    $email_rec = $_POST['email2'];
}
?>

<head>
    <title>Jazz Burguer - Login</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="description" content="Lanches  ">
    <meta name="author" content="Kauê Lima">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/login.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/bootstrap-social.css" rel="stylesheet" id="bootstrap-css">

    <link rel="stylesheet" href="css/stylelogin.css">
    <link rel="icon" href="images/favicon-nova.ico" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>


    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>


<!------ Include the above in your HEAD tag ---------->

<!-- login start -->
<body>
  <div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
     
    <div class="content">      
      <!--FORMULÁRIO DE LOGIN-->
      <div id="login">
        <form method="post" action=""> 
          <h1>Login</h1> 
          <p> 
            <label for="nome_login">Seu nome</label>
            <input id="nome_login" name="nome_login" required="required" type="text" placeholder="ex. contato@htmlecsspro.com"/>
          </p>
           
          <p> 
            <label for="email_login">Seu e-mail</label>
            <input id="email_login" name="email_login" required="required" type="password" placeholder="ex. senha" /> 
          </p>
           
          <p> 
            <input type="checkbox" name="manterlogado" id="manterlogado" value="" /> 
            <label for="manterlogado">Manter-me logado</label>
          </p>
           
          <p> 
            <input type="submit" value="Logar" /> 
          </p>
           
          <p class="link">
            Ainda não tem conta?
            <a href="#paracadastro">Cadastre-se</a>
          </p>
        </form>
      </div>
 
      <!--FORMULÁRIO DE CADASTRO-->
      <div id="cadastro">
        <form method="post" action=""> 
          <h1>Cadastro</h1> 
           
          <p> 
            <label for="nome_cad">Seu nome</label>
            <input id="nome_cad" name="nome_cad" required="required" type="text" placeholder="nome" />
          </p>
           
          <p> 
            <label for="email_cad">Seu e-mail</label>
            <input id="email_cad" name="email_cad" required="required" type="email" placeholder="contato@htmlecsspro.com"/> 
          </p>
           
          <p> 
            <label for="senha_cad">Sua senha</label>
            <input id="senha_cad" name="senha_cad" required="required" type="password" placeholder="ex. 1234"/>
          </p>
           
          <p> 
            <input type="submit" value="Cadastrar"/> 
          </p>
           
          <p class="link">  
            Já tem conta?
            <a href="#paralogin"> Ir para Login </a>
          </p>
        </form>
      </div>
    </div>
  </div>  
</body>








<?php

if (isset($_POST['email2']) and $_POST['email2'] != '') {

?>

    <script>
        $("#modal-login").modal("show");
    </script>

<?php } ?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<script src="js/mascaras.js"></script>




<!--AJAX PARA INSERÇÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#btn-cadastro').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "cadastrar-usuario.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    $('#mensagem').removeClass()

                    if (mensagem == 'Cadastrado com Sucesso!!') {

                        $('#mensagem').addClass('text-success')

                        document.getElementById('username').value = document.getElementById('email').value;

                        document.getElementById('pass').value = document.getElementById('senha').value;

                        $('#nome').val('')
                        $('#telefone').val('')
                        $('#cpf').val('')
                        $('#email').val('')
                        $('#senha').val('')

                        //$('#btn-fechar').click();
                        //location.reload();






                    } else {

                        $('#mensagem').addClass('text-danger')
                    }

                    $('#mensagem').text(mensagem)

                },

            })
        })
    })
</script>





<!--AJAX PARA RECUPERAR A SENHA -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#btn-rec').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "recuperar.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    $('#mensagem2').removeClass()

                    if (mensagem == 'Senha enviada para o seu Email!') {

                        $('#mensagem2').addClass('text-success')

                        document.getElementById('username').value = document.getElementById('email-recuperar').value;


                        $('#email-recuperar').val('')


                        //$('#btn-fechar').click();
                        //location.reload();



                    } else {

                        $('#mensagem2').addClass('text-danger')
                    }

                    $('#mensagem2').text(mensagem)

                },

            })
        })
    })
</script>
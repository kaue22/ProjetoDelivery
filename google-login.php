<?php
ob_start();
session_start();
if (empty($_SESSION["userLogin"])) {
    echo "<h1>Teste</h1>";
    /**Auth Google */

    $google = new \League\OAuth2\Client\Provider\Google(GOOGLE);
    $error = filter_input(INPUT_GET,"error",FILTER_SANITIZE_STRING);
    $code = filter_input(INPUT_GET,"CODE",FILTER_SANITIZE_STRING);

    if($error){
        echo "<h1>Você Precisa de Autorização para continuar</h1>";
    }

    echo "<a title='Logar com o google' href=''>Google Login </a>";
} else {
    echo "<h1>User</h1>";
    var_dump($_SESSION["userLogin"]);
}


ob_end_flush();

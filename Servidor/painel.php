<?php

include_once 'users.class.php';

if(isset($_COOKIE['SSID'])){
    $user = new User();
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        if($user->permission() != 1 && $user->permission() != 2){
            unset($_COOKIE['SSID']);
            setcookie('SSID', '', time() - 3600);
            header('location: pagina_not.html');
        }
        // QUANDO TENTAR ACESSAR PAGINAS QUE NÃO EXISTEM OU QUE SÃO DE ACESSO RESTRITO, 
        // DEVE-SE COLOCAR EM UMA PAGINA DE ERRO PARAGINA NAO EXISTE
    }else{
        unset($_COOKIE['SSID']);
        setcookie('SSID', '', time() - 3600);
        header('location: pagina_not.html');
    }
}
// ESSA PAGINA É SO PARA TESTE !!!
// PRECISA CRIAR NA CLASSE SECURITY UMA FUNÇÃO PARA DIRECIONAR AS VIEW CORRETAS A CADA TIPO DE USUARIO, OU SEJA SUAS PERMISSOES
?>

<html>
    <header>
    </header>
    <body>
        <button onclick="logout();></button>
    </body>
</html>

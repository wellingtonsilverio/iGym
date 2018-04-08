<?php
include_once 'services/users.class.php';

if(isset($_COOKIE['SSID'])){

    $user = new User();
    
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        
        if($user->permission() != 1 && $user->permission() != 2){ // CHECA NÃO TENHA PERMISSAO AQUI
            unset($_COOKIE['SSID']);
            setcookie('SSID', '', time() - 3600);
            header('location: not_found.php');
        }else{ // CASO ESTEJA TUDO CERTO !!

            // FUNCIONALIDADE PARA FAZER LOGOUT
            if(isset($_GET['l'])){
                if($user->Logout($_COOKIE['SSID'], "web") == "1"){
                    // CASO O TOKEN TENHA SIDO EXCLUIDO COM SUCESSO DO BANCO DE DADOS, ENTÃO É DELETADO DA MAQUINA
                    unset($_COOKIE['SSID']);
                    setcookie('SSID', '', time() - 3600);
                    header('location: index.php');                   
                }else{
                    // ALGUM ERRO NO DESLOGAR
                }
            }

            // LOAD CURRENT PAGE 
        }
    }else{ // CASO O TOKEN NÃO SEJA INVALIDO
        unset($_COOKIE['SSID']);
        setcookie('SSID', '', time() - 3600);
        header('location: not_found.php');
    }
}else{ // CASO NÃO POSSUA TOKEN
    header('location: not_found.php');
}
?>

<html>
    <header>
    </header>
    <body>
        <form method="GET">
            <input name="l" value="true" hidden="true" />
            <input type="submit" value="Sair"/>
        </form>
    </body>
</html>

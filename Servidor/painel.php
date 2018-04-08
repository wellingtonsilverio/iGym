<?php
include_once 'users.class.php';

if(isset($_COOKIE['SSID'])){

    $user = new User();
    
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        
        if($user->permission() != 1 && $user->permission() != 2){ // CHECA NÃO TENHA PERMISSAO AQUI
            unset($_COOKIE['SSID']);
            setcookie('SSID', '', time() - 3600);
            header('location: pagina_not.html');
        }else{ // CASO ESTEJA TUDO CERTO !!

            // FUNCIONALIDADE PARA FAZER LOGOUT
            if(isset($_GET['l'])){
                if($user->Logout($_COOKIE['SSID'], "web") == "1"){
                    unset($_COOKIE['SSID']);
                    setcookie('SSID', '', time() - 3600);
                    header('location: index.php');                   
                }else{
                    // ALGUM ERRO NO DESLOGAR
                }
            }
        }
    }else{ // CASO O TOKEN NÃO SEJA INVALIDO
        unset($_COOKIE['SSID']);
        setcookie('SSID', '', time() - 3600);
        header('location: pagina_not.html');
    }
}else{ // CASO NÃO POSSUA TOKEN
    header('location: pagina_not.html');
}
?>

<html>
    <header>
    </header>
    <body>
        <form method="GET">
            <input name="l" value="true" hidden="true" />
            <input type="submit" value="Sair"/>
            <!-- <button onclick="submit();">Enviar</button> -->
        </form>
    </body>

    // <script>
    //     function submit(){
            
    //     }
    // </script>
</html>

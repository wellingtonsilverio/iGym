<?php
include_once 'services/users.class.php';
include_once 'services/view/main-admin/main-adm-dashboard.php';
include_once 'services/view/acad-admin/acad-adm-dashboard.php';

if(isset($_COOKIE['SSID'])){

    $user = new User();
    
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        
        if($user->get_permission() == 1 || $user->get_permission() == 2){ // CASO ESTEJA TUDO CERTO !!
            
            /* FUNCIONALIDADES INTERNAS DA APLICAÇÃO/PAGINA */
            
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

            $page = ""; // CURRENT PAGE FOR LOAD
            // LOAD CURRENT PAGE FOR USER PERMISSION
            if($user->get_permission() == 1){
                $adm = new MainAdmin($user);
                $page = get_main_admin_page($adm);
            }else if($user->get_permission() == 2){

            }else{
                // DO NOTHING
            }

        }else{ // CHECA NÃO TENHA PERMISSAO AQUI
            unset($_COOKIE['SSID']);
            setcookie('SSID', '', time() - 3600);
            header('location: not_found.php');                      
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
        <div style="width:100%; height:100%;"><?php echo $page; ?></div>
    </body>
</html>

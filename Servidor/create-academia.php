<?php
include_once 'services/users.class.php';
include_once 'services/view/main-admin/main-adm-dashboard.php';
include_once 'services/view/acad-admin/acad-adm-dashboard.php';

if(isset($_COOKIE['SSID'])){

    $user = new User();
    
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        
        if($user->get_permission() == 1){ // CHECA NÃO TENHA PERMISSAO AQUI
            // FUNÇÃO
        }else{ // CASO ESTEJA TUDO CERTO !!
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
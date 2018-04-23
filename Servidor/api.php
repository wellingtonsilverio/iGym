<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/x-www-form-urlencoded");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// LIBRARIES
include_once __DIR__.'/app/model/users.class.php';

if(isset($_POST['f'])){

    $function = $_POST['f']; // FUNÇÃO DESEJADA DA API

    // FUNÇÕES SEM TOKEN
    if($function == "1"){// LOGIN FUNCTION FOR ALL USER TYPES
        // IF ALL INFORMATION ARE HERE, WE CAN TRY A LOGIN
        if(isset($_POST['e'],$_POST['p'],$_POST['m'],$_POST['s'],$_SERVER['REMOTE_ADDR'])){
            echo User::Logar($_POST['e'],$_POST['p'],$_POST['m'],$_POST['s'],$_SERVER['REMOTE_ADDR']);
        }else{
            // DO NOTHING
        }
    }
    else if($function == "2"){ // LOGOUT FUNCTION FOR APP
        $user = new User();
        if($user->CheckToken($_POST['tkn'], "app") == true){
            if($user->Logout($_POST['tkn'], "app") == "1"){
                echo '1';                   
            }else{ // ALGUM ERRO NO DESLOGAR
                echo '-1';
            }
        }else{
            echo '-1';
        }
    }

    // FUNÇÕES COM TOKEN ...

}else{
    // DO NOTHING
}

?>
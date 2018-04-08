<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/x-www-form-urlencoded");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// LIBRARIES
include_once 'users.class.php';

if(isset($_POST['f'])){
    $function = $_POST['f'];
    // LOGIN FUNCTION
    if($function == "1"){
        // IF ALL INFORMATION ARE HERE, WE CAN TRY A LOGIN
        if(isset($_POST['e'],$_POST['p'],$_POST['m'],$_POST['s'],$_SERVER['REMOTE_ADDR'])){
            echo User::Logar($_POST['e'],$_POST['p'],$_POST['m'],$_POST['s'],$_SERVER['REMOTE_ADDR']);
        }else{
            // DO NOTHING
        }
    }

}else{
    // DO NOTHING
}

?>
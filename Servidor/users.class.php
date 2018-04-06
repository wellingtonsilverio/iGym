<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
//header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/x-www-form-urlencoded");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// LIBRARIES
include_once 'class/connect.pdo.php';
include_once 'class/security.php';

// USER CLASS FOR ANYTHING WHO USERS CAN DO
class User extends Security{
    private $Connection;
    private $DataBaseInstance;

    function __construct (){
        // INITIALIZE THE DATABASE CONECTION
        $this->Connection = new Connect();
        $this->DataBaseInstance = $this->Connection->getInstance();
    }

    public function Logar($usr_email, $usr_pass, $usr_mac, $usr_system, $usr_ip){
        
        $SqlQuery = $this->DataBaseInstance->prepare("SELECT usr_id, usr_permission FROM `users` WHERE (`usr_email` = ? OR `usr_nick` = ?) AND `usr_pass` = ?");
        $SqlQuery->execute(array($usr_email, $usr_email, $usr_pass));
        
        if($return = $SqlQuery->fetchObject()){
            return parent::CreateToken($usr_system, $usr_mac, $usr_ip, $return->usr_id, $return->usr_permission);
        }else{
            return "";
        }
    }
}



//RECUPERAÇÃO DO FORMULÁRIO
//$data = file_get_contents("php://input");
//$objData = json_decode($data);




// function login($conn, $array){
//   $users = $conn->prepare("SELECT id, name, email, coins, nick FROM `users` WHERE (`email` = ? OR `nick` LIKE ?) AND `pass` = ?");
//   $users->execute($array);
//   return json_encode($users->fetch(PDO::FETCH_ASSOC));
// }
// function getUser($conn, $array){
//   $users = $conn->prepare("SELECT id, name, email, coins, nick FROM `users` WHERE `id` = ?");
//   $users->execute($array);
//   return json_encode($users->fetch(PDO::FETCH_ASSOC));
// }
//
// if(isset($objData->key) && $objData->key == "c7c841c6aabbbb2d742580b3f816817a"){
//   if(isset($objData->email) && isset($objData->pass)){
//     $email = $objData->email;
//     $pass = md5(sha1($objData->pass));
//
//     echo login($conn, array($email, $email, $pass));
//   }
//
//   if(isset($objData->id) && isset($objData->coins)){
//     $id = $objData->id;
//     $coins = $objData->coins;
//
//
//     $incrementCoins = $conn->prepare("UPDATE `users` SET `coins`= `coins` + ? WHERE `id` = ?");
//     if($incrementCoins->execute(array($coins, $id))){
//       $insertPrize = $conn->prepare("INSERT INTO `prizes` (`user`, `value`) VALUES (?,?)");
//       if($insertPrize->execute(array($id, $coins))){
//         echo getUser($conn, array($id));
//       }
//
//     }
//   }
//   if(isset($objData->name) && isset($objData->email) && isset($objData->newpass)){
//     $name = $objData->name;
//     $email = $objData->email;
//     $nick = $objData->nick;
//     $pass = md5(sha1($objData->newpass));
//
//     $insert = $conn->prepare("INSERT INTO `users` (`name`, `email`, `nick`, `pass`) VALUES (?,?,?,?)");
//     if($insert->execute(array($name, $email, $nick, $pass))){
//       echo login($conn, array($email, $email, $pass));
//     }
//   }
//   if(isset($objData->prizeId)){
//     $id = $objData->prizeId;
//
//     $hasPrize = $conn->prepare("SELECT `date` FROM `prizes` WHERE (`user` = ?) AND (`date` > DATE_SUB(NOW(), INTERVAL 12 HOUR)) LIMIT 1");
//     $hasPrize->execute(array($id));
//     echo json_encode($hasPrize->fetch(PDO::FETCH_ASSOC));
//   }
// }


?>

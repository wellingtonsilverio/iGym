<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
//header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/x-www-form-urlencoded");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// LIBRARIES
include_once 'connect.pdo.php';

class Security{

    private $DataBaseInstance;

    // FUNÇÃO PARA CRIAR UM TOKEN QUANDO FIZER O LOGIN
    protected function CreateToken($op, $mac, $ip, $usr){

        $token = md5($op.$usr->usr_id.date("Y-m-d H:i:s"));
        $DataBaseInstance = Connect::getInstance();

        // IF LOGIN IS FROM WEB OR APPLICATION, WE CREATE A TOKEN FOR USER AND SAVE ON CLIENT COMPUTER,
        // FOR SECURITY, WE NEED FIND ONE KEY WHO WE CAN FIND ONLY IN CLIENT COMPUTER.
        // SESSION IS CREATED FOR TRANSFER USER CLASS
        
        // PRIMEIRO É VERIFICADO SE EXISTE ALGUM TOKEN NO NOME DO USUARIO
        $SqlQuery = $DataBaseInstance->prepare("SELECT *FROM `security_token` WHERE `tkn_usr_id`= ? AND `tkn_op` = ?");
        $SqlQuery->execute(array($usr->usr_id,$op));
        if($result = $SqlQuery->fetchObject()){
            if(!(self::DeleteToken($result->tkn_id, $result->tkn_usr_id))){
                return "-1";
            }
        }

        // DEPOIS É FEITO O REGISTRO DO NOVO TOKEN
        $SqlQuery = $DataBaseInstance->prepare("INSERT INTO `security_token` (`tkn_id`,`tkn_usr_id`,`tkn_mac`,`tkn_op`,`tkn_ip`,`tkn_date_create`,`tkn_date_update`) VALUES (?,?,?,?,?,?,?)");
        if($SqlQuery->execute(array($token, $usr->usr_id,$mac,$op,$ip,date("Y-m-d"),date("Y-m-d")))){
            // DEPOIS É VERIFICADO QUAL A ORIGEM DO TOKEN, CASO FOIR WEB É REGISTRADO COMOM COOKIE, CASO SEJA O APP É ENVIADO COMO RETORNO VIA HTTP
            if($op == "web"){
                setcookie("SSID",$token, time() + (10 * 365 * 24 * 60 * 60));
                return "1";
            }else if($op == "app"){
                return $token;
            }else{
                // DO NOTHING
            }
        }
    }
    protected function UpdateToken(){}
    // FUNÇÃO PARA DELETAR O TOKEN
    protected function DeleteToken($token, $usr_id){
        $DataBaseInstance = Connect::getInstance();
        $SqlQuery = $DataBaseInstance->prepare("DELETE FROM `security_token` WHERE `tkn_usr_id`= ? AND `tkn_id` = ?");
        if($SqlQuery->execute(array($usr_id,$token))){
            return true;
        }else{
            return false;
        }
    }
    // FUNÇÃO PARA CHECKAR O TOKEN
    protected function CheckToken($token){
        $DataBaseInstance = Connect::getInstance();
        $SqlQuery = $DataBaseInstance->prepare("SELECT tkn_op, tkn_usr_id FROM `security_token` WHERE `tkn_id` = ?");
        $SqlQuery->execute(array($token));
        if($result = $SqlQuery->fetchObject()){
            return $result->tkn_usr_id; 
        }else{
            return 0;
        }
    }
}

?>
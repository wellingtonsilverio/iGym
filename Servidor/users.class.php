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

    // DADOS DE CONEXÃO
    private $DataBaseInstance;

    // DADOS DO USUARIO
    private $id = 0;
    private $email = "";
    private $nick = "";
    private $password = "";
    private $permission = 0;
    private $status = 0;

    // GETTERS AND SETTER
    public function permission(){
        return $this->permission;
    }

    function __construct (){
        // INITIALIZE THE DATABASE CONECTION
        $this->DataBaseInstance = Connect::getInstance();
    }

    // FUNÇÃO ESTATICA POIS É UZADA EXTERNAMENTE A CLASSE 
    public static function Logar($usr_email, $usr_pass, $usr_mac, $usr_system, $usr_ip){

        $DataBaseInstance = Connect::getInstance();
        $SqlQuery = $DataBaseInstance->prepare("SELECT * FROM `users` WHERE (`usr_email` = ? OR `usr_nick` = ?) AND `usr_pass` = ?");
        $SqlQuery->execute(array($usr_email, $usr_email, $usr_pass));
        
        if($return = $SqlQuery->fetchObject()){
            // CHECK IF THE CURRENT USER IS IN AMBIENT OPERATING CORRECT
            if(($return->usr_permission == 3 && $usr_system == "app") || ((($return->usr_permission == 1 || $return->usr_permission == 2) && $usr_system == "web"))){
                return parent::CreateToken($usr_system, $usr_mac, $usr_ip, $return);
            }else{
                return "-1";
            }
        }else{
            return "";
        }
    }
    // ESTA FUNÇÃO É INTERNA QUANDO QUEREMOS CARREGAR USUARIO
    private function LoadUser(){
        $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_id` = ?");
        $SqlQuery->execute(array($this->usr_id));
        if($return = $SqlQuery->fetchObject()){
            $this->permission = $return->usr_permission;   
        }
    }
    // FUNÇÃO PUBLICA PARA VERIFICARMOS SE O TOKEN EXISTE 
    public function CheckToken($token, $op){
        if( ($this->usr_id = parent::CheckToken($token)) != 0){
            self::LoadUser();
            if(($op == "app" && $this->permission == 3) || ($op == "web" && ($this->permission == 1 || $this->permission == 2))){
                return true; 
            }else{
                return false;
            }
            return true;
        }else{
            return false;
        }
    }
}
?>

<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
// header("Access-Control-Allow-Origin:*");
// header("Content-Type: application/x-www-form-urlencoded");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// LIBRARIES
include_once __DIR__.'/../controller/connect.pdo.php';
include_once __DIR__.'/../controller/security.php';

// USER CLASS FOR ANYTHING WHO USERS CAN DO
class User extends Security{

    // DADOS DE CONEXÃO
    private $DataBaseInstance;

    // DADOS DO USUARIO
    protected $usr_id = 0;
    protected $usr_email = "";
    protected $usr_nick = "";
    protected $usr_password = "";
    protected $usr_permission = 0;
    protected $usr_status = 0;
    
    function __construct (){}

    // GETTERS AND SETTER
    protected function set_user($user){
        $this->usr_id = $user->usr_id;
        $this->usr_email = $user->usr_email;
        $this->usr_nick = $user->usr_nick;
        $this->usr_password = $user->usr_password;
        $this->usr_permission = $user->usr_permission;
        $this->usr_status = $user->usr_status;
    }

    public function get_permission(){
        return $this->usr_permission;
    }
    
    

    // FUNÇÃO ESTATICA POIS É UZADA EXTERNAMENTE A CLASSE 
    public static function Logar($usr_email, $usr_pass, $usr_mac, $usr_system, $usr_ip){

        $DataBaseInstance = Connect::getInstance();
        $SqlQuery = $DataBaseInstance->prepare("SELECT * FROM `users` WHERE (`usr_email` = ? OR `usr_nick` = ?) AND `usr_pass` = ?");
        $SqlQuery->execute(array($usr_email, $usr_email, $usr_pass));
        
        if($return = $SqlQuery->fetchObject()){
            // CHECK IF THE CURRENT USER IS IN AMBIENT OPERATING CORRECT
            if((($return->usr_permission == 3 || $return->usr_permission == 4 ) && $usr_system == "app") || ($usr_system == "web" && ($return->usr_permission == 1 || $return->usr_permission == 2))){
                return parent::CreateToken($usr_system, $usr_mac, $usr_ip, $return);
            }else{
                return "-1";
            }
        }else{
            return "";
        }
    }
    // FUNÇÃO EXTERNA A CLASSE PARA FAZER LOGOFF
    public function Logout($token, $op){
        if((($this->usr_permission == 3 || $this->usr_permission == 4 ) && $op == "app") || ($op == "web" && ($this->usr_permission == 1 || $this->usr_permission == 2))){
            if(parent::DeleteToken($token, $this->usr_id)){
                
                if($op == "web"){
                    setcookie("SSID", false, 1);
                }
                
                return "1";
            }else{
                return "-1";
            }
        }
    }
    // ESTA FUNÇÃO É USADA PARA ATUALIZAR O USUARIO
    protected function UpdateUser($email, $nick, $pass, $name, $status){
        
        $this->DataBaseInstance = Connect::getInstance();

        if($this->usr_email != $email){
            $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_email` = ?");
            $SqlQuery->execute(array($email));
            if($SqlQuery->fetchObject()){
                return 2;
            }
        }
        if($this->usr_nick != $nick){
            $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_nick` = ?");
            $SqlQuery->execute(array($nick));
            if($res = $SqlQuery->fetchObject()){
                return 3;
            }
        }
        // PRIMEIRO EXECUTA A ALTERAÇÃO DE ACORDO SE EXISTE OU NÃO MUDANÇA NA SENHA
        if($pass != ""){
            $SqlQuery = $this->DataBaseInstance->prepare("UPDATE `users` SET `usr_date_update` = ? , `usr_status` = ? , `usr_name` = ? , `usr_email` = ? , `usr_nick` = ? , `usr_pass` = ? WHERE `usr_id` = ?");
            if($SqlQuery->execute(array(date('Y-m-d'),$status,$name,$email,$nick, $pass, $this->usr_id))){
                return 1;
            }else{
                return 4;
            }
        }else{
            $SqlQuery = $this->DataBaseInstance->prepare("UPDATE `users` SET `usr_date_update` = ? , `usr_status` = ? , `usr_name` = ? , `usr_email` = ? , `usr_nick` = ? WHERE `usr_id` = ?");
            if($SqlQuery->execute(array(date('Y-m-d'),$status,$name,$email,$nick, $this->usr_id))){
                return 1;
            }else{
                return 4;
            }
        }
    }
    // ESTA FUNÇÃO É INTERNA QUANDO QUEREMOS CARREGAR USUARIO
    protected function LoadUser(){
        $this->DataBaseInstance = Connect::getInstance();
        $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_id` = ?");
        $SqlQuery->execute(array($this->usr_id));
        if($return = $SqlQuery->fetchObject()){
            $this->usr_email = $return->usr_email;
            $this->usr_nick = $return->usr_nick;
            $this->usr_permission = $return->usr_permission;   
        }
    }
    // ESTA FUNÇÃO TEM COMO OBJETIVO CRIAR USUARIOS
    protected function CreateUser($email, $pass, $name, $nick){
        $this->DataBaseInstance = Connect::getInstance();

        $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_email` = ?");
        $SqlQuery->execute(array($email));
        if($SqlQuery->fetchObject()){
            echo "aqui msm";
            return -2;
        }
        $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `users` WHERE `usr_nick` = ?");
        $SqlQuery->execute(array($nick));
        if($res = $SqlQuery->fetchObject()){
            return -3;
        }
        
        $SqlQuery = $this->DataBaseInstance->prepare("INSERT INTO `users` (`usr_email`,`usr_nick`,`usr_pass`,`usr_name`,`usr_permission`,`usr_date_create`,`usr_date_update`,`usr_status`) VALUES (?,?,?,?,?,?,?,?)");
        if($SqlQuery->execute(array($email, $nick, $pass, $name, 2, date('Y-m-d'), date('Y-m-d'), 3))){
            return $this->DataBaseInstance->lastInsertId();
        }else{
            return -4;
        }
    }
    // ESTA FUNÇÃO TEM COMO OBJETIVO DELETAR O USUARIO
    protected function DeleteUser(){
        $this->DataBaseInstance = Connect::getInstance();
        $SqlQuery = $this->DataBaseInstance->prepare("DELETE FROM `users` WHERE `usr_id` = ?");
        if($SqlQuery->execute(array($this->usr_id))){
            return true;
        }else{
            return false;            
        }
    }
    // FUNÇÃO PUBLICA PARA VERIFICARMOS SE O TOKEN EXISTE 
    public function CheckToken($token, $op){
        if( ($this->usr_id = parent::CheckToken($token)) != 0){
            self::LoadUser();
            if((($this->usr_permission == 3 || $this->usr_permission == 4 ) && $op == "app") || ($op == "web" && ($this->usr_permission == 1 || $this->usr_permission == 2))){
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

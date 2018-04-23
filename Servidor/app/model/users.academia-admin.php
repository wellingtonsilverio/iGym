<?php

include_once __DIR__."/users.class.php";
include_once __DIR__.'/../controller/connect.pdo.php';

class Gym extends User{

    // DADOS DE CONEXÃO
    private $DataBaseInstance;
    
    // DADOS DE USUARIOS
    private $gym_id = 0;
    private $gym_name = "";
    private $gym_cnpj = 0;
    private $gym_num = 0;
    private $gym_gps_location = 0;
    private $gym_create = "";
    private $gym_update = "";
    private $gym_status = 0;

    function __construct(){}
    
    // GETTERS E SETTERS
    public function get_name(){
        return $this->gym_name;
    }
    public function get_cnpj(){
        return $this->gym_cnpj;
    }
    public function get_num(){
        return $this->gym_num;
    }
    public function get_gps_location(){
        return $this->gym_gps_location;
    }
    public function get_create(){
        return $this->gym_create;
    }
    public function get_update(){
        return $this->gym_update;
    }
    public function get_status(){
        return $this->gym_status;
    }
    public function get_email(){
        return $this->usr_email;
    }
    public function get_nick(){
        return $this->usr_nick;
    }
    public function LoadGym($id){
        
        $this->gym_id = $id;
        $this->DataBaseInstance = Connect::getInstance();

        $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `gyms` WHERE `gym_id` = ?");
        $SqlQuery->execute(array($this->gym_id));
        if($return = $SqlQuery->fetchObject()){
            $this->gym_name = $return->gym_name;
            $this->gym_cnpj = $return->gym_cnpj; 
            $this->gym_num = $return->gym_num;
            $this->gym_gps_location = $return->gym_gps_location; 
            $this->gym_create = $return->gym_create;
            $this->gym_update = $return->gym_update; 
            $this->gym_status = $return->gym_status;
            $this->usr_id = $return->gym_usr_id;
            parent::LoadUser();
            return "1";
        }else{
            return "2";
        }
        // precisa carregar o parent::usuario e a academia
    }
    
    // ESTA FUNÇÃO SERVE PARA CRIAR USUARIOS
    public function CreateGym($email, $pass, $name, $nick, $cnpj, $num, $gps){
        $res = parent::CreateUser($email, $pass, $name, $nick);
        if($res > 0){
            $this->DataBaseInstance = Connect::getInstance();
            $SqlQuery = $this->DataBaseInstance->prepare("INSERT INTO `gyms` (`gym_usr_id`,`gym_name`,`gym_cnpj`,`gym_num`,`gym_gps_location`,`gym_create`,`gym_update`,`gym_status`) VALUES (?,?,?,?,?,?,?,?)");
            if($SqlQuery->execute(array($res, $name, $cnpj, $num, $gps, date('Y-m-d'), date('Y-m-d'), 1))){
                return 1;
            }else{
                return 2;
            }
        }else{
            return $res;
        }
    }

    public function DeleteGym(){
        $this->DataBaseInstance = Connect::getInstance();
        $SqlQuery = $this->DataBaseInstance->prepare("DELETE FROM `gyms` WHERE `gym_id` = ?");
        if($SqlQuery->execute(array($this->gym_id))){
            return parent::DeleteUser();
        }else{
            return false;
        }
    }

    public function UpdateGym($name, $cnpj, $num, $gps_location, $status, $email, $nick, $pass){
        $this->DataBaseInstance = Connect::getInstance();
        $SqlQuery = $this->DataBaseInstance->prepare("UPDATE `gyms` SET `gym_update` = ? , `gym_name` = ? , `gym_cnpj` = ? , `gym_num` = ? , `gym_gps_location` = ? , `gym_status` = ? WHERE `gym_id` = ?");
        if($SqlQuery->execute(array(date('Y-m-d'),$name, $cnpj, $num, $gps_location, ($status == "Ativado" ? 1 : 2), $this->gym_id))){
            return parent::UpdateUser($email, $nick, $pass, $name, ($status == "Ativado" ? 1 : 2));
        }else{
            return 5;
        }
    }
}
?>



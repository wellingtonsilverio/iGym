<?php
// LIBRARIES
include_once __DIR__.'/users.class.php';
include_once __DIR__.'/../controller/connect.pdo.php';

class MainAdmin extends User{

    private $DataBaseInstance;

    // CONSTRUCTOR WITHOUT USER  
    function __construct($user){
        if(isset($user)){            
            parent::set_user($user);
            $this->DataBaseInstance = Connect::getInstance();
        }else{
            return null;
        }
    }

    /*
    AS FUNÇÕES QUE INCLUEM NA CLASSE DE ADMINISTRAÇÃO PRICIPAL SÃO A DE CRUD DE ACADEMIA, 
    CRUD DE EXERCICIOS, 
    
    */
    public function LoadAcademias(){
        $return = [];
        if($this->get_permission() == 1){
            $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `gyms` ");
            $SqlQuery->execute();

            while($result = $SqlQuery->fetchObject()){
                array_push($return, $result);
            }
        }
        return $return;
    }

}
?>
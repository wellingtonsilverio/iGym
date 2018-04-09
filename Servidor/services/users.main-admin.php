<?php
// LIBRARIES
include_once 'users.class.php';
include_once 'controller/connect.pdo.php';

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
        $return = "";
        if($this->get_permission() == 1){
            $SqlQuery = $this->DataBaseInstance->prepare("SELECT * FROM `gyms` ");
            $SqlQuery->execute();
            while($result = $SqlQuery->fetchObject()){
                $return .= '
                <tr>
                    <th>'.$result->gym_name.'</th>
                    <th> X </th>
                    <th><a href="edit-academia.php?c="'.$result->gym_id.'>Editar</a></th>
                </tr>
                ';
            }

            return $return;
        }
    }

}
?>
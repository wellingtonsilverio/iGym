<?php
// FOR DOWNLOAD FILE WHEN MADE EXTERNAL ACCESS 
//header("Access-Control-Allow-Origin:*");
//header("Content-Type: application/x-www-form-urlencoded");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

class Security{

    protected function CreateToken($op, $mac, $ip, $id, $nivel){

        $token = null;
        
        // IF LOGIN IS FROM WEB OR APPLICATION, WE CREATE A TOKEN FOR USER AND SAVE ON CLIENT COMPUTER,
        // FOR SECURITY, WE NEED FIND ONE KEY WHO WE CAN FIND ONLY IN CLIENT COMPUTER.
        if($op == "web"){
            
        }else if($op == "app"){

        }else{
            // DO NOTHING
        }
        return $token;
    }

    protected function UpdateToken(){

    }
}

?>
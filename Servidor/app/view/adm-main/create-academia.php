<?php

include_once __DIR__."/../../model/users.academia-admin.php";

if(isset($_POST['crt-usr'])){
    
    $academia_user = new Gym();
    $resu = $academia_user->CreateGym($_POST['email'],$_POST['senha'],$_POST['name'],$_POST['nick'],$_POST['cnpj'],$_POST['num'],$_POST['gps']);
    
    if($resu == 1){ // COMPLETED
        header("location: ../dashboard");
    }else if($resu == 2){ // CASE EMAIl IS REGISTRED 
        
    }else if($resu == 3){ // CASE NICK IS REGISTRED 
        
    }else{

    }
}

?>

<div>
    <button onclick="javascript: window.location.assign('../dashboard');">Voltar</button>
    <form id="frm-crt" method="POST" autocomplete="off">
        <input name="crt-usr" hidden/>
        E-MAIL (*): <input type="text" id="email" name="email"/> 
        | CONFIRMAÇÃO E-MAIL: <input type="text" id="c-email" name="c-email"/>
        | SENHA (*): <input type="text" id="senha" name="senha"/>
        | CONFIRMAÇÃO SENHA: <input type="text" id="c-senha" name="c-senha"/>
        <br><br>
        NICK : <input type="text" id="nick" name="nick"/>
        | NOME (*): <input type="text" id="name" name="name"/>
        | CNPJ: <input type="text" id="cnpj" name="cnpj"/>
        | NUMERO: <input type="text" id="num" name="num"/>
        <br><br>
        GPS LOCALIZAÇÃO: <input type="text" id="gps" name="gps"/>
    </form>
    <button onclick="javascript: CreateUser();">Criar</button>
</div>

<script type="text/javascript">
    
    function CreateUser(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(re.test(String(document.getElementById('email').value).toLowerCase())){
            if(document.getElementById('email').value == document.getElementById('c-email').value){
                if((document.getElementById('senha').value == document.getElementById('c-senha').value ) && document.getElementById('senha').value != ""){
                    if(document.getElementById('name').value != ""){
                        document.getElementById('frm-crt').submit();
                    }else{
                        alert("Preencha TODOS os campos !");
                    }
                }else{
                    alert("Confirmação de SENHA Invalida !");
                }
            }else{
                alert("Confirmação de E-Mail INCORRETA !");
            }
        }else{
            alert("E-mail INVALIDO !");
        }
    }

</script>
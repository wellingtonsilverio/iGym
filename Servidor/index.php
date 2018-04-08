<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// ESTA PAGINA E SO PARA TESTE DA API !!
include_once 'class/security.php';
include_once 'users.class.php';

if(isset($_COOKIE['SSID'])){
    $user = new User();
    if($user->CheckToken($_COOKIE['SSID'], "web") == true){
        header('location: painel.php');
    }else{
        unset($_COOKIE['SSID']);
        setcookie('SSID', '', time() - 3600);
    }
}
?>

<html>
    <header></header>
    <body>
        <input type="text" id="email" placeholder="e-mail"/>
        <input type="password" id="senha" placeholder="senha"/>
        <button onclick="logar();">Logar</buton>
    </body>

    <script>
        function logar(){
            let email =  document.getElementById('email').value;
            let pass = document.getElementById('senha').value;
            
            xhr = new XMLHttpRequest(); // Conecta ao servidor para fazer a conexão

            xhr.open('POST',encodeURI("api.php"));
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                var response = xhr.responseText;
                if(response == "1"){
                    window.location.assign('painel.php');
                }else{
                    alert("Login ou senha incorretos !");
                }
            };
            xhr.send("f=1&e="+email+"&p="+pass+"&m=&s=web");
        }
    </script>
</html>
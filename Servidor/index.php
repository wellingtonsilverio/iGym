<?php
// ESTA PAGINA E SO PARA TESTE DA API !!


// PRECISA CRIAR NA CLASSE SECURITY UMA FUNÇÃO PARA DIRECIONAR AS VIEW CORRETAS A CADA TIPO DE USUARIO, OU SEJA SUAS PERMISSOES
// CASO ESTEJA LOGADO, JOGA ELE PARA A PAGINA DE PAINEL

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
                alert(response);
            };
            xhr.send("f=1&e="+email+"&p="+pass+"&m=&s=web");
        }
    </script>
</html>
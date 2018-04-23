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

            xhr.open('POST',encodeURI("../api.php"));
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                var response = xhr.responseText;
                
                if(response == "1"){
                    window.location.assign('dashboard');
                }else{
                    alert("Login ou senha incorretos !");
                }
            };
            xhr.send("f=1&e="+email+"&p="+pass+"&m=&s=web");
        }
    </script>
</html>
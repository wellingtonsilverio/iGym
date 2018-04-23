<?php

include_once __DIR__."/../../model/users.academia-admin.php";

    if(isset($_GET['ID'])){
        $academia_user = new Gym();
        if($academia_user->LoadGym($_GET['ID']) != "1"){
            header("location: ../../404");
        }else{
            // FUNÇÕES DA PAGINA
            if(isset($_POST['gym-usr'])){
                if($_POST['gym-usr'] == "del"){
                    if($academia_user->DeleteGym()){
                        header("location: ../../dashboard");          
                    }
                }else{
                    $res = $academia_user->UpdateGym($_POST['name'], $_POST['cnpj'], $_POST['numero'], $_POST['gps_location'], $_POST['status'], $_POST['email'], $_POST['nick'], $_POST['senha']);
                    if($res == 1){
                        header("location: ../../dashboard");
                    }else if($res == 2){
                        echo "2";
                        // já existe o email
                    }else if($res == 3){
                        echo "3";
                        // ja existe o nick
                    }else{
                        echo "4";
                        // outro erro
                    }
                }
            }else{
                // DO NOTHING
            }
        }
    }else{
        header("location: ../dashboard");
    }
?>
<div>
    <form id="frm-edit" method="POST" autocomplete="off">
        <input id="gym-usr" name="gym-usr" hidden />

        DADOS DE ACADEMIA
        <br>
        Nome:<input id="name" name="name" type="text" value="<?php echo $academia_user->get_name();?>" disabled/>
        CNPJ:<input id="cnpj" name="cnpj" type="text" value="<?php echo $academia_user->get_cnpj();?>" disabled/>
        NUMERO:<input id="numero" name="numero" type="text" value="<?php echo $academia_user->get_num();?>" disabled/>
        <br><br>
        GPS:<input id="gps_location" name="gps_location" type="text" value="<?php echo $academia_user->get_gps_location();?>" disabled/>
        DATA CRIAÇÃO<input type="text" value="<?php echo $academia_user->get_create();?>" disabled/>
        DATA ATUALIZAÇÃO<input type="text" value="<?php echo $academia_user->get_update();?>" disabled/>
        <br><br>
        STATUS: <select name="status" id="status" disabled>
            <option values="1" selected>Ativado</option>
            <option values="2"  <?php echo ($academia_user->get_status() != 1 ? "selected" : ""); ?>>Bloqueado</option>
        </select>
        <br><br>
        DADOS DE USUARIO
        <br>
        EMAIL: <input id="email" name="email" type="text" value="<?php echo $academia_user->get_email();?>" disabled/>
        NOVA SENHA:<input id="senha" name="senha" type="text" value="" disabled/>
        NICK:<input id="nick" name="nick" type="text" value="<?php echo $academia_user->get_nick();?>" disabled/>
        <br>
        CONFIRMAR E-MAIL <input id="c-email" type="text" value="" disabled/>
        CONFIRMAR SENHA:<input id="c-senha" type="text" value="" disabled/>
    </form>
    <button onclick="window.location.assign('../../dashboard');">Voltar</button>
    <button onclick="javascript: habilitar_edicao(this);">Editar</button>
    <button onclick="javascript: deletar();">Deletar</button>
    <button id="btn-salvar" onclick="javascript: salvar_gym();" disabled>Salvar</button>
</div>
<script>
    var initial_email = "<?php echo $academia_user->get_email();?>";
    function habilitar_edicao(btn){
        document.getElementById('name').disabled = false;
        document.getElementById('cnpj').disabled = false;
        document.getElementById('numero').disabled = false;
        document.getElementById('gps_location').disabled = false;
        document.getElementById('status').disabled = false;
        document.getElementById('btn-salvar').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('nick').disabled = false;
        document.getElementById('c-email').disabled = false;
        document.getElementById('senha').disabled = false;
        document.getElementById('c-senha').disabled = false;
        btn.disabled = true;
    }
    function deletar(){
        document.getElementById('gym-usr').value = "del";
        document.getElementById('frm-edit').submit();
    }
    function salvar_gym(){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(re.test(String(document.getElementById('email').value).toLowerCase())){
            if(document.getElementById('senha').value == document.getElementById('c-senha').value){
                if(document.getElementById('email').value != initial_email){
                    if(document.getElementById('email').value == document.getElementById('c-email').value){
                        document.getElementById('frm-edit').submit();
                    }else{
                        alert("Confirmação de E-mail INCORRETA !");
                    }
                }else{
                    document.getElementById('frm-edit').submit();
                }
            }else{
                alert("Confirmação de senha !");
            }
        }else{
            alert("E-mail Invalido !");
        }
    }
</script>
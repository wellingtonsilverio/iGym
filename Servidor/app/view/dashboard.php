<?php
include_once __DIR__.'/../model/users.main-admin.php';

// FUNCIONALIDADE DE LOGOFF
if(isset($_POST['leave'])){
    if($user->Logout($_COOKIE['SSID'], "web")){
        // CASO O TOKEN TENHA SIDO EXCLUIDO COM SUCESSO DO BANCO DE DADOS, ENTÃO É DELETADO DA MAQUINA
        setcookie('SSID', false, 1);
        header('location:  /');                   
    }else{
    // ALGUM ERRO NO DESLOGAR
    }
}
?>

<html>
    <header>
    </header>
    <body>
        <form method="POST">
            <input name="leave" value="true" hidden="true" />
            <input type="submit" value="Sair"/>
        </form>
        <div style="width:100%; height:100%;">
        <?php
            $adm_pages = ["dashboard","create-academia","edit-academia"];
            $aca_pages = ["dashboard"];

            // CARREGA A DASHBOARD CORRETA
            if($user->get_permission() == "1"){
                // LOAD ANOTHER PAGES
                if(isset($_GET['SP'])){
                    if(in_array($_GET['SP'] , $adm_pages)){
                        if(file_exists(__DIR__.'/adm-main/'.$_GET['SP'].'.php')){
                            include __DIR__.'/adm-main/'.$_GET['SP'].'.php';    
                        }else{
                            header("location: ../404");
                        }
                    }else{
                        header("location: ../404");
                    }
                }else{
                    include __DIR__.'/adm-main/dashboard.php';
                }
            }else if($user->get_permission() == "2"){
                // LOAD ANOTHER PAGES
                if(isset($_GET['SP'])){

                }else{
                    // include __DIR__.'/adm-main/dashboard.php';
                }
            }else{
                echo 'here';
                header("location: ../404");
            }
        ?>
        </div>
    </body>
</html>
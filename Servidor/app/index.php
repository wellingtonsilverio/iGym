<?php

include_once __DIR__.'/model/users.class.php';

$adm_pages = ["dashboard"];
$aca_pages = ["dashboard"];

if(isset($_COOKIE['SSID'])){
    
        $user = new User();
        if($user->CheckToken($_COOKIE['SSID'], "web") == true){
            if(isset($_GET['P'])){
                if((in_array($_GET['P'], $adm_pages) && $user->get_permission() == "1") || (in_array($_GET['P'], $aca_pages) && $user->get_permission() == "2")){
                    if(file_exists(__DIR__.'/view/'.$_GET['P'].'.php')){
                        include __DIR__.'/view/'.$_GET['P'].'.php';
                    }else{
                        include __DIR__.'/404.php';
                    }
                }else{
                    include __DIR__.'/404.php';
                }
            }else{
                header("location: dashboard");
            }
        }else{
            if(isset($_GET['P'])){
                if(in_array($_GET['P'], $adm_pages) || in_array($_GET['P'], $aca_pages)){
                    include __DIR__.'/404.php';
                }else{
                    if(file_exists(__DIR__.'/view/'.$_GET['P'].'.php')){
                        include __DIR__.'/view/'.$_GET['P'].'.php';
                    }else{
                        include __DIR__.'/404.php';
                    }
                }
            }else{
                header("location: login");
            }
        }
}else{
    if(isset($_GET['P'])){
        if(in_array($_GET['P'], $adm_pages) || in_array($_GET['P'], $aca_pages)){
            include __DIR__.'/404.php';
        }else{
            if(file_exists(__DIR__.'/view/'.$_GET['P'].'.php')){
                include __DIR__.'/view/'.$_GET['P'].'.php';
            }else{
                include __DIR__.'/404.php';
            }
        }
    }else{
        header("location: login");
    }
}
?>
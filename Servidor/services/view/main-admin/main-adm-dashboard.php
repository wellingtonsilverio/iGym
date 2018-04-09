<?php

include_once __DIR__.'/../../users.main-admin.php';

function get_main_admin_page($main_admin_user){

    $lista_academias = $main_admin_user->LoadAcademias();

    return '
<div>
    <table>
    <tr>
        <th>Nome Academia</th>
        <th>Nº Usuarios</th>
        <th>Funções</th>
    </tr>
    '.$lista_academias.'
    </table>
    <br>
    <button onclick="javascrip: window.location.assign(\'create-academia.php\');">Criar Nova Academia</button>
</div>
    ';
}

?>


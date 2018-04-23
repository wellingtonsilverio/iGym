<div>
    <button onclick="javascript: window.location.assign('dashboard/create-academia');">Criar Academia</button>
    <table>
        <tr>
            <th>Nome</th>
            <th>Data Criação</th>
            <th>Ultima Atualização</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php
            
            $mainadmin = new MainAdmin($user);
            $list = $mainadmin->LoadAcademias();
            
            for($i = 0; $i < count($list); $i++){
                echo '
                <tr>
                    <th>'.$list[$i]->gym_name.'</th>
                    <th>'.$list[$i]->gym_create.'</th>
                    <th>'.$list[$i]->gym_update.'</th>
                    <th>'. ($list[$i]->gym_status == 1 ? "Ativada" : "Bloqueado" ).'</th>
                    <th><a href="dashboard/edit-academia/'.$list[$i]->gym_id.'">Editar</a></th>
                </tr>
                ';
            }
        ?>
    </table>
</div>
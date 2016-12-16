<?php

$tabela = '<table border=1>
    <th>ID</th>
    <th>Username</th>
    <th>Password</th>
    <th>&nbsp;</th>';
if(!empty($usuarios)){
    foreach($usuarios as $usuarios_id => $usuario){
        $tabela .= '<tr>
            <td>'.$usuario['id'].'</td>
            <td>'.$usuario['username'].'</td>
            <td>'.(!empty($usuario['passwd']) ? 'sim' : 'não').'</td>
            <td>[edit] [delete]</td>
        </tr>';
    }
}
$tabela .= '</table>';
?>
<h1>Lista de Usuários</h1>

<?php echo $tabela; ?>
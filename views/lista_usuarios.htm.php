<?php

$tabela = '<table border=1 class="table table-striped table-hover">
    <colgroup width=10%>
    <colgroup width=40%>
    <colgroup width=30%>
    <colgroup width=19%>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>&nbsp;</th>
        </tr>
    </thead>';
if(!empty($usuarios)){
    foreach($usuarios as $usuarios_id => $usuario){
        $tabela .= '<tr>
            <td>'.$usuario['id'].'</td>
            <td>'.$usuario['username'].'</td>
            <td>'.(!empty($usuario['passwd']) ? 'sim' : 'não').'</td>
            <td align="right">
                <a href="'.Mapper::url('/home/crud-usuario/'.$usuario['id']).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i> Editar</a>
                <a rel="'.$usuario['id'].'" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Excluir</a>
            </td>
        </tr>';
    }
}
$tabela .= '</table>';
?>
<h3>Gestão de Usuários</h3>
<div><strong>Lista de Usuários</strong></div>

<div align="right"><a href="<?php echo Mapper::url('/home/crud-usuario'); ?>" class="btn btn-primary btn-sm">Inserir Usuário</a></div>
<?php echo $tabela; ?>

<script type='text/javascript'>
    $(function (){
        $('.btn-delete').click(function (){
            if(confirm('Tem certeza de que deseja excluir este usuário?')){
                $.post("<?php echo Mapper::url('/home/crud-usuario'); ?>", {delete_usuarios_id: $(this).attr('rel')}, function (result){
                    window.location.href = window.location.href;
                }, 'json');
            }
        });
    });
</script>
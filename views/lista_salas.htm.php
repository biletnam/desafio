<?php

$tabela = '<table border=1 class="table table-striped table-hover">
    <colgroup width=10%>
    <colgroup width=10%>
    <colgroup width=15%>
    <colgroup width=15%>
    <colgroup width=20%>
    <colgroup width=30%>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Capacidade</th>
            <th>Possui Datashow</th>
            <th>Observações</th>
            <th>&nbsp;</th>
        </tr>
    </thead>';
if(!empty($salas)){
    foreach($salas as $salas_id => $sala){
        $tabela .= '<tr>
            <td>'.$sala['id'].'</td>
            <td>'.$sala['nome'].'</td>
            <td>'.$sala['capacidade'].'</td>
            <td>'.($sala['datashow'] > 0 ? 'sim' : 'não').'</td>
            <td>'.$sala['observacoes'].'</td>
            <td align="right">
                <a href="'.Mapper::url('/salas/crud-sala/'.$sala['id']).'" class="btn btn-xs btn-warning btn-edit"><i class="fa fa-pencil"></i> Editar</a>
                <a rel="'.$sala['id'].'" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Excluir</a>
            </td>
        </tr>';
    }
}
$tabela .= '</table>';
?>
<h3>Gestão de Salas</h3>
<div><strong>Lista de Salas</strong></div>

<div align="right"><a href="<?php echo Mapper::url('/salas/crud-sala'); ?>" class="btn btn-primary btn-sm">Inserir Sala</a></div>
<?php echo $tabela; ?>

<script type='text/javascript'>
    $(function (){
        $('.btn-delete').click(function (){
            if(confirm('Tem certeza de que deseja excluir este usuário?')){
                $.post("<?php echo Mapper::url('/salas/crud-sala'); ?>", {delete_salas_id: $(this).attr('rel')}, function (result){
                    window.location.href = window.location.href;
                }, 'json');
            }
        });
    });
</script>
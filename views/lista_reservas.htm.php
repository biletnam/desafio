<?php


if(!empty($salas)){

    $tabela = '<p>&nbsp;
    <table border=1 class="table table-striped table-hover">
        <colgroup width="10%">
        <colgroup width="50%">';

    $tabela .= '<thead><tr><th>&nbsp;</th>';

    foreach($salas as $salas_id => $sala){
        $tabela .= '<th>'.$sala['nome'].'</th>';
    }

    $tabela .= '</tr></thead><tbody>';

    for($hora = 8; $hora <=19; $hora++){

        $hora_grade = str_zero($hora, 2).':00';
        $tabela .= '<tr><td align="center">'.$hora_grade.'</td>';

        if(!empty($salas)){
            foreach($salas as $salas_id => $sala){
                $reserva = $reservas[$hora_grade][$salas_id];
                if(!empty($reserva)){
                    $tabela .= '<td class="reservado" data-id="'.$reserva['id'].'"> RESERVADO para '.$reserva['usuario']['username'].' </td>';
                } else {
                    $tabela .= '<td class="livre" data-hora="'.$hora.'" data-sala="'.$salas_id.'"> &nbsp;</td>';
                }
            }
        }
        $tabela .= '</tr>';
    }

    $tabela .= '</tbody></table>';
} else {
    $tabela = '<p>Cadastre algumas salas para ver grade de reservas.';
}


?>
<h3>Reservas de Salas</h3>
<div>Clique em um horário para criar reserva.</div>

<?php echo $tabela; ?>

<script type='text/javascript'>
var reservas = <?php echo json_encode($reservas); ?>;
$(function (){
    $('td.livre').click(function (){
        window.location.href = "<?php echo Mapper::url('/reservas/crud/'); ?>?hora=" + $(this).attr('data-hora') + '&sala=' + $(this).attr('data-sala');
    });

    $('td.reservado').click(function (){
        if(confirm('Tem certeza de que deseja excluir reserva de sala?')){
            window.location.href = "<?php echo Mapper::url('/reservas/crud'); ?>/" + $(this).attr('data-id');
        }
    });
});
</script>
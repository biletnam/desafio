<?php


$tabela = '';
if(!empty($salas)){

    // verifica se há erros
    if(!empty($erro_message)){
        $tabela = '<div class="alert alert-dismissible alert-danger" style="margin-top: 20">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Erro:</strong> '.$erro_message.'
        </div>';
    }

    $tabela .= '<p>&nbsp; <table border=1 class="table table-striped table-hover"><thead><tr><th>&nbsp;</th>';

    foreach($salas as $salas_id => $sala){
        $tabela .= '<th>'.$sala['nome'].'</th>';
    }

    $tabela .= '</tr></thead><tbody>';

    for($hora = 8; $hora <=19; $hora++){

        $hora_grade = str_zero($hora, 2).':00';
        $tabela .= '<tr><td width="10%" align="center">'.$hora_grade.'</td>';

        if(!empty($salas)){
            foreach($salas as $salas_id => $sala){
                $reserva = $reservas[$hora_grade][$salas_id];
                if(!empty($reserva)){
                    $tabela .= '<td width="120" class="reservado" data-id="'.$reserva['id'].'" data-horagrade="'.$hora_grade.'" data-sala="'.$salas_id.'"> RESERVADO para '.$reserva['usuario']['username'].' </td>';
                } else {
                    $tabela .= '<td width="120" class="livre" data-horagrade="'.$hora_grade.'" data-hora="'.$hora.'" data-sala="'.$salas_id.'"> &nbsp;</td>';
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
const user = <?php echo json_encode($usuario_logado['id']); ?>;
var reservas = <?php echo json_encode($reservas); ?>;
$(function (){
    $('td.livre').click(function (){
        var horario = $(this).attr('data-horagrade');
        if(horario in reservas){
            pode_reservar = true;
            _.forEach(reservas[horario], function (item){
                console.log(item.usuarios_id, user == item.usuarios_id);
                if(user == item.usuarios_id){
                    pode_reservar = false;
                }
            });

            if(!pode_reservar){
                alert('Você não pode reservar outra sala no mesmo horário.');
                return false;
            }
        }

        window.location.href = "<?php echo Mapper::url('/reservas/crud/'); ?>?hora=" + $(this).attr('data-hora') + '&sala=' + $(this).attr('data-sala');
    });

    $('td.reservado').click(function (){
        // var reserva = reservas[$(this).attr('data-horagrade')][$(this).attr('data-sala')];

        // if(user != reserva.usuaros_id){
        //     alert('Você não tem perissão para excluir esta reserva.');
        //     return false;
        // }

        if(confirm('Tem certeza de que deseja excluir reserva de sala?')){
            window.location.href = "<?php echo Mapper::url('/reservas/crud'); ?>/" + $(this).attr('data-id');
        }
    });
});
</script>
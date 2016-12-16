<?php

$crud_type = 'Inserir Sala';
if(!empty($sala)){
    $crud_type = 'Editar Sala';
}

?>
<h3>Gestão de Salas</h3>


<form method="post" class="form-horizontal" id="formSala">
    <fieldset>
        <legend><?php echo $crud_type; ?></legend>
        <div class="form-group">
            <label for="inputNome" class="col-lg-2 control-label">Nome</label>
            <div class="col-lg-10">
                <input type="text" name="nome" value="<?php echo $sala['nome']; ?>" class="form-control" id="inputNome" placeholder="Nome">
            </div>
        </div>
        <div class="form-group">
            <label for="inputCapacidade" class="col-lg-2 control-label">Capacidade</label>
            <div class="col-lg-10">
                <input type="number" name="capacidade" value="<?php echo $sala['capacidade']; ?>" class="form-control" id="inputCapacidade" placeholder="Capacidade de Pessoas">
            </div>
        </div>
        <div class="form-group">
            <label for="textObservacoes" class="col-lg-2 control-label">Observações</label>
            <div class="col-lg-10">
                <textarea name="observacoes" class="form-control" rows="3" id="textObservacoes"><?php echo $sala['observacoes']; ?></textarea>
                <span class="help-block">Detalhes da sala.</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Possui Datashow?</label>
            <div class="col-lg-10">
                <div class="radio">
                    <label>
                        <input type="radio" name="datashow" id="datashow1" value="1">
                        Sim
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="datashow" id="datashow0" value="0">
                        Não
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <a href="<?php echo Mapper::url('/salas'); ?>" class="btn btn-default">Voltar</a>
                <input type="submit" class="btn btn-primary" value="Salvar">
            </div>
        </div>
    </fieldset>
</form>

<script type='text/javascript'>
$(function () {
    $('#datashow<?php echo $sala['datashow']; ?>').attr('checked', '');
})
</script>
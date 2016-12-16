<?php

$crud_type = 'Inserir Usuário';
if(!empty($usuario)){
    $crud_type = 'Editar Usuário';
}

?>
<h3>Gestão de Usuários</h3>


<form method="post" class="form-horizontal" id="formSala">
    <fieldset>
        <legend><?php echo $crud_type; ?></legend>
        <div class="form-group">
            <label for="inputUsername" class="col-lg-2 control-label">Username</label>
            <div class="col-lg-10">
                <input type="text" name="username" value="<?php echo $usuario['username']; ?>" class="form-control" id="inputUsername" placeholder="Username">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPasswd" class="col-lg-2 control-label">Senha</label>
            <div class="col-lg-10">
                <input type="password" name="passwd" class="form-control" id="inputPasswd" placeholder="Senha">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <a href="<?php echo Mapper::url('/usuarios'); ?>" class="btn btn-default">Voltar</a>
                <input type="submit" class="btn btn-primary" value="Salvar">
            </div>
        </div>
    </fieldset>
</form>

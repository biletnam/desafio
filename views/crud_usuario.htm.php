<?php

$crud_type = 'Inserir Usuário';
if(!empty($usuario)){
    $crud_type = 'Editar Usuário';
}

?>
<h3>Gestão de Usuários</h3>

<div><strong><?php echo $crud_type; ?></strong></div>

<form method="post" id="formUsuario">
    <input type="text" name="username" value="<?php echo $usuario['username']; ?>" placeholder="Informe seu login" />
    <input type="password" name="passwd" placeholder="Informe sua senha" />
    <input type="submit" value="Salvar" />
</form>

<a href="<?php echo Mapper::url('/home'); ?>" class="btn btn-default">Voltar</a>
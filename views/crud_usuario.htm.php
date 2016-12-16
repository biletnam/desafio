<?php

$crud_type = 'Inserir Usuário'
?>
<h1>Gestão de Usuários</h1>

<div><strong><?php echo $crud_type; ?></strong></div>

<form method="post" id="formUsuario">
    <input type="text" name="username" value="<?php echo $usuario['username']; ?>" placeholder="Informe seu login" />
    <input type="password" name="passwd" placeholder="Informe sua senha" />
    <input type="submit" value="Salvar" />
</form>
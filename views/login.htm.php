<?php

?>

<div class="login-content">

    <form method="post" class="form-horizontal" id="formLogin">
        <fieldset>
            <legend>Login</legend>

            <div class="alert alert-dismissible alert-danger" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again.
            </div>

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
                    <input type="submit" class="btn btn-primary" value="Entrar">
                </div>
            </div>
        </fieldset>
    </form>
</div>

<script type='text/javascript'>
var exibeErro = <?php echo json_encode($erro_login === true); ?>;
$(function (){
    if(exibeErro) {
        $('.alert').fadeIn('slow');
    }
})
</script>
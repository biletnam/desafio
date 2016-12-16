<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/superhero/bootstrap.min.css" rel="stylesheet" integrity="sha384-Xqcy5ttufkC3rBa8EdiAyA1VgOGrmel2Y+wxm4K3kI3fcjTWlDWrlnxyD6hOi3PF" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo Mapper::url('/public/css/main.css'); ?>" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://bootswatch.com/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo Mapper::url('/public/js/custom.js'); ?>"></script>

        <title>Office in a Box</title>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Office in a Box</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $get['controller'] == 'home'? 'active' : ''; ?>"><a href="<?php echo Mapper::url('/'); ?>">Home</a></li>
                        <li class="<?php echo $get['controller'] == 'usuarios'? 'active' : ''; ?>"><a href="<?php echo Mapper::url('/usuarios'); ?>">Usuários</a></li>
                        <li class="<?php echo $get['controller'] == 'salas'? 'active' : ''; ?>"><a href="<?php echo Mapper::url('/salas'); ?>">Salas</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo Mapper::url('/home/logout'); ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="content-margin"> <?php echo $contentForLayout; ?> </div>
        </div>
    </body>
</html>
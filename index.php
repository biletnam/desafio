<?php

define(ROOT, dirname(__FILE__));
define(BASE_URL, 'http://'.$_SERVER["HTTP_HOST"]);

require ROOT.'/lib/config.php';
require ROOT.'/lib/utils.php';
require ROOT.'/lib/inflector.php';
require ROOT.'/lib/mapper.php';
require ROOT.'/models/app_model.php';
require ROOT.'/controllers/app_controller.php';
require ROOT.'/controllers/home_controller.php';

$HomeController = new HomeController();
$HomeController->run();
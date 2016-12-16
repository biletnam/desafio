<?php

define(ROOT, dirname(__FILE__));

require ROOT.'/lib/config.php';
require ROOT.'/lib/utils.php';
require ROOT.'/lib/mapper.php';
require ROOT.'/models/app_model.php';
require ROOT.'/controllers/app_controller.php';
require ROOT.'/controllers/home_controller.php';

$HomeController = new HomeController();

$HomeController->filter();
$HomeController->index();
$HomeController->render();
<?php

require_once SYSTEMPATH.'core/base.php';
base::autoRequire(SYSTEMPATH.'core', array('initialize.php', 'base.php'));
base::autoRequire(SYSTEMPATH.'libraries');


require_once APPPATH.'controllers/base.controller.php';
require_once APPPATH.'models/base.model.php';

$app = new application();
$app->run();
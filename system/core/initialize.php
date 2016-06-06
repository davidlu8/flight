<?php

require_once SYSTEMPATH.'core/base.php';
base::autoRequire(SYSTEMPATH.'core', array('initialize.php', 'base.php'));
base::autoRequire(SYSTEMPATH.'libraries');


require_once APPPATH.'controllers/base.controller.php';

echo '<pre>';
print_r(FL::uri());

$app = new application();
$app->run();
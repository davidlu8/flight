<?php

require_once SYSTEMPATH.'core/base.php';
base::autoRequire(SYSTEMPATH.'core', array('initialize.php', 'base.php'));
base::autoRequire(SYSTEMPATH.'libraries');

echo '<pre>';
print_r(FL::uri());

$app = new application();
$app->run();
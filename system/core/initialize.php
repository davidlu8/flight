<?php

require_once SYSTEMPATH.'core/base.php';
base::autoRequire(SYSTEMPATH.'core', array('initialize.php', 'base.php'));

echo '<pre>';
print_r(FL::uri);
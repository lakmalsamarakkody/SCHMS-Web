<?php

// SET ABS PATH FOR INIT
define('ABS_PATH', realpath(__DIR__ . '/..'));

// COMPOSER AUTO LOAD
require_once ABS_PATH.'/libs/autoload.php';

// INCLUDE CORE COMPONENTS
require_once ABS_PATH.'/app/core/Registry.php';
require_once ABS_PATH.'/app/core/Config.php';
require_once ABS_PATH.'/app/core/Session.php';
require_once ABS_PATH.'/app/core/Loader.php';
require_once ABS_PATH.'/app/core/Document.php';
require_once ABS_PATH.'/app/core/Twig.php';
require_once ABS_PATH.'/app/core/Request.php';

require_once ABS_PATH.'/app/core/App.php';
require_once ABS_PATH.'/app/core/Controller.php';
require_once ABS_PATH.'/app/core/Database.php';

?>
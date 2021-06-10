<?php

use Bitrix\Main\Loader;

$moduleId = basename(__DIR__);

Loader::registerAutoLoadClasses($moduleId, [
    str_replace('.', '_', $moduleId) => 'install/index.php',
]);

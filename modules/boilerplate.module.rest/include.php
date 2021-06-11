<?php

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(basename(__DIR__), [
    'boilerplate_module_rest' => 'install/index.php',
]);

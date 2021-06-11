<?php

\Bitrix\Main\Loader::includeModule(GetModuleID(__DIR__));

return [
    "parent_menu" => 'global_menu_settings',
    "sort" => 100,
    "text" => 'Вебхуки',
    "title" => 'Настройка вебхуков сайта',
    "url" => 'rest/',
    "items_id" => "rest_settings",
];

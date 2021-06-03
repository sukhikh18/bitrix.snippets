<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Boilerplate\Module\ORM\DataTable;
use Bitrix\Main\Loader;

Loader::includeModule('boilerplate.module.orm');

return [
    [
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => "Результаты таблицы тестового модуля",
        'title' => "",
        'url' => 'perfmon_table.php?lang=ru&table_name=' . DataTable::getTableName(),
    ]
];

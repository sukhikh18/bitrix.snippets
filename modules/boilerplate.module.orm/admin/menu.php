<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$aMenu = array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => "Результаты таблицы модуля",
        'title' => "",
        'url' => 'perfmon_table.php?lang=ru&table_name=' . DataTable::getTableName(),
    ),
);

return $aMenu;
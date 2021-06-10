<?php require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php');
\Bitrix\Main\Loader::includeModule('boilerplate.module.menupage');
$module = new boilerplate_module_menupage();
require($module::getRoot() . '/modules/' . $module::MODULE_ID . '/admin/' . $module::ADMIN_PAGE_NAME);

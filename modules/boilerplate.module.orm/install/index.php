<?php

use Bitrix\Main\ModuleManager;

IncludeModuleLangFile(__FILE__);

if (class_exists('boilerplate_module_orm')) {
    return;
}

class boilerplate_module_orm extends CModule
{

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = 'boilerplate.module.orm';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'] ?? '';
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'] ?? '';
        $this->MODULE_NAME = 'Пример модуля';
        $this->MODULE_DESCRIPTION = 'Тестовый модуль для разработчиков, можно использовать как основу для разработки новых модулей для 1С:Битрикс';
        $this->PARTNER_NAME = '';
        $this->PARTNER_URI = '';
    }

    function DoInstall()
    {
        global $APPLICATION, $DB;

        if (!CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            $APPLICATION->ThrowException('Версия главного модуля ниже 14. Не поддерживается технология D7, необходимая модулю. Пожалуйста обновите систему.');
        }

        /**
         * Install Database
         */
        $sqlErrors = $DB->RunSQLBatch(__DIR__ . '/db/install.sql');
        if ($sqlErrors) throw new Error(implode(", <br>\n", $sqlErrors));

        /**
         * Install Events
         */

        /**
         * Install Files
         */

        ModuleManager::RegisterModule($this->MODULE_ID);
    }

    function DoUninstall()
    {
        global $DB;

        /**
         * Uninstall Database
         */
        $DB->RunSQLBatch(__DIR__ . '/db/uninstall.sql');

        /**
         * Uninstall Events
         */

        /**
         * Uninstall Files
         */

        UnRegisterModule($this->MODULE_ID);
    }
}
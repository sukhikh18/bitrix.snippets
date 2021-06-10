<?php

use Bitrix\Main\ModuleManager;

IncludeModuleLangFile(__FILE__);

if (class_exists('boilerplate_module_menupage')) {
    return;
}

class boilerplate_module_menupage extends CModule
{
    const MODULE_ID = 'boilerplate.module.menupage';
    const ADMIN_PAGE_NAME = 'settings.php';

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = self::MODULE_ID;
        $this->MODULE_VERSION = $arModuleVersion['VERSION'] ?? '';
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'] ?? '';
        $this->MODULE_NAME = 'Пример модуля';
        $this->MODULE_DESCRIPTION = 'Тестовый модуль для разработчиков, можно использовать как основу для разработки новых модулей для 1С:Битрикс';
        $this->PARTNER_NAME = '';
        $this->PARTNER_URI = '';
    }

    /**
     * Get application folder.
     * @return string /document/local (when exists) or /document/bitrix
     */
    public static function getRoot()
    {
        $local = $_SERVER['DOCUMENT_ROOT'] . '/local';
        if (1 === preg_match('#local[\\\/]modules#', __DIR__) && is_dir($local)) {
            return $local;
        }

        return $_SERVER['DOCUMENT_ROOT'] . BX_ROOT;
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

        /**
         * Install Events
         */

        /**
         * Install Files
         */
        CopyDirFiles(__DIR__ . '/admin', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/admin');

        ModuleManager::RegisterModule(self::MODULE_ID);
    }

    function DoUninstall()
    {
        global $DB;

        /**
         * Uninstall Database
         */

        /**
         * Uninstall Events
         */

        /**
         * Uninstall Files
         */
        DeleteDirFilesEx('/bitrix/admin/' . self::ADMIN_PAGE_NAME);

        UnRegisterModule(self::MODULE_ID);
    }
}
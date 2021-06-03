<?php

use Bitrix\Main;
use Bitrix\Main\ModuleManager;
use Boilerplate\Module\ORM\DataTable;

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
        // Required before module register.
        require_once __DIR__ . '/../lib/datatable.php';

        if (!CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            Main\Application::getInstance()->ThrowException('Версия главного модуля ниже 14. Не поддерживается технология D7, необходимая модулю. Пожалуйста обновите систему.');
        }

        /**
         * Install Database
         *
         * @var Main\Data\Connection|Main\DB\Connection $conn
         */
        $conn = Main\Application::getConnection();

        if (!$conn->isTableExists(DataTable::getTableName())) {
            Main\Entity\Base::getInstance(DataTable::class)->createDBTable();
        }

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
        Main\Loader::includeModule($this->MODULE_ID);

        /**
         * Uninstall Database
         */
        Main\Application::getConnection()->dropTable(DataTable::getTableName());

        /**
         * Uninstall Events
         */

        /**
         * Uninstall Files
         */

        UnRegisterModule($this->MODULE_ID);
    }
}
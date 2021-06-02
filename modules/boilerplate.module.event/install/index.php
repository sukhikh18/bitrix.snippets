<?php

use Bitrix\Main\ModuleManager;
use Boilerplate\Module\Event\EventHandler;

IncludeModuleLangFile(__FILE__);

if (class_exists('boilerplate_module_event')) {
    return;
}

class boilerplate_module_event extends CModule
{

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = 'boilerplate.module.event';
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

        /**
         * Install Events
         */
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('main', 'OnPageStart', $this->MODULE_ID, EventHandler::class, 'OnPageStart');

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

        /**
         * Uninstall Events
         */
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'OnPageStart', $this->MODULE_ID);

        /**
         * Uninstall Files
         */

        UnRegisterModule($this->MODULE_ID);
    }
}
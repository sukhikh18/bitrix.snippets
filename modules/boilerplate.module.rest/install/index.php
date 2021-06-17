<?php

use Bitrix\Main;

if (class_exists('boilerplate_module')) {
    return;
}

class boilerplate_module_rest extends CModule
{

    public function __construct()
    {
        IncludeModuleLangFile(__FILE__);

        $arModuleVersion = ['VERSION' => '', 'VERSION_DATE' => ''];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = GetModuleID(__DIR__);
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = 'Пример модуля';
        $this->MODULE_DESCRIPTION = 'Тестовый модуль для разработчиков, можно использовать как основу для разработки новых модулей для 1С:Битрикс';
        $this->PARTNER_NAME = '';
        $this->PARTNER_URI = '';
    }

    function InstallDB()
    {
    }

    function InstallEvents()
    {
        $obEventManager = Main\EventManager::getInstance();
        $obEventManager->registerEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            $this->MODULE_ID,
            Service::class,
            'getDescription'
        );
    }

    function InstallFiles()
    {
    }

    function DoInstall()
    {
        if (!CheckVersion(Main\ModuleManager::getVersion('main'), '14.00.00')) {
            Main\Context::getApplication()->ThrowException('Версия главного модуля ниже 14. Не поддерживается технология D7, необходимая модулю. Пожалуйста обновите систему.');
        }

        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();

        Main\UrlRewriter::add(
            SITE_ID,
            [
                'CONDITION' => '#^/api/#',
                'RULE' => '',
                'ID' => 'bitrix:rest.hook',
                'PATH' => static::getRoot() . '/modules/' . $this->MODULE_ID . '/admin/rest.php',
                'SORT' => 100,
            ]
        );

        Main\ModuleManager::RegisterModule($this->MODULE_ID);
    }

    function UnInstallDB()
    {
    }

    function UnInstallEvents()
    {
        $obEventManager = Main\EventManager::getInstance();
        $obEventManager->unRegisterEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            $this->MODULE_ID,
            Service::class,
            'getDescription'
        );
    }

    function UnInstallFiles()
    {
    }

    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();

        Main\UrlRewriter::delete(
            SITE_ID,
            ["CONDITION" => '#^/api/#']
        );

        Main\ModuleManager::UnRegisterModule($this->MODULE_ID);
    }

    /**
     * Get module holder folder name.
     * @return string /local (when exists) or /bitrix
     */
    public static function getRoot()
    {
        return in_array('local', explode(DIRECTORY_SEPARATOR, __DIR__)) ?
            '/local' : BX_ROOT;
    }
}
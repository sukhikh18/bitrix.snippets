<?php
/**
 * @var Bitrix\Main\Application $APPLICATION
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_admin.php");
$APPLICATION->AddHeadString('<base href="/bitrix/admin/">');

?>
<div class="adm-workarea">
    <?$APPLICATION->IncludeComponent(
        "bitrix:rest.hook",
        ".default",
        [
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => "/api/",
            "COMPONENT_TEMPLATE" => ".default",
            "SEF_URL_TEMPLATES" => [
                "list" => "",
                "event_list" => "event",
                "event_edit" => "event/#id#/",
                "ap_list" => "ap",
                "ap_edit" => "ap/#id#/",
            ]
        ],
        false
    );?>
    <?php if ('/api/' === $APPLICATION->GetCurDir()): ?>
    <br>
    <a href="javascript:void(0)" class="adm-btn adm-btn-green"
       onclick="BX.PopupMenu.show('rest_hook_menu', this, [
           { 'href':'/api/event/0/', 'text':'Исходящий вебхук' },
           { 'href':'/api/ap/0/', 'text':'Входящий вебхук' },
       ])">Добавить вебхук</a>
    <?php endif; ?>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");

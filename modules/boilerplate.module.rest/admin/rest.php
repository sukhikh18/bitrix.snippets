<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_admin.php"); ?>
    <div class="adm-workarea">
        <?$APPLICATION->IncludeComponent(
            "bitrix:rest.hook",
            ".default",
            [
                "SEF_MODE" => "Y",
                "SEF_FOLDER" => "/api/", // "/bitrix/admin/rest.php",
                "COMPONENT_TEMPLATE" => ".default",
                "SEF_URL_TEMPLATES" => [
//                    "list" => "",
//                    "event_list" => "/event/",
//                    "event_edit" => "/event/#id#/",
//                    "ap_list" => "/ap/",
//                    "ap_edit" => "/ap/#id#/", //
                ]
            ],
            false
        );?>
        <br>
        <a href="javascript:void(0)" class="adm-btn adm-btn-green"
           onclick="BX.PopupMenu.show('rest_hook_menu', this, [{
              'href':'?event/0/',
              'text':'Исходящий вебхук'
           },{
              'href':'?ap/0/',
              'text':'Входящий вебхук'
           }])">
            Добавить вебхук
        </a>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
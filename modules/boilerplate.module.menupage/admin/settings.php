<?php

use Bitrix\Main\Config\Option;

$APPLICATION->SetTitle('Настройки сайта');

$arMessages = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["save"] !== '' && check_bitrix_sessid())
{
    // Do action
    Option::set('boilerplate.module.menupage', 'SITE_NAME', $_POST['SITE_NAME']);

    $arMessages[] = ['MESSAGE' => 'Настройки обновлены', 'TYPE' => 'OK'];
}

$aTabs = [
    [
        "DIV" => "main",
        "TAB" => 'Настройки',
        "ICON" => "main_user_edit",
        "TITLE" => 'Настройки',
    ]
];

$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php');

foreach($arMessages as $message) {
    CAdminMessage::ShowMessage($message);
}
?>
<form method="POST" action="?action=save&lang=<? echo LANGUAGE_ID ?>&<?= $tabControl->ActiveTabParam() ?>"
      enctype="multipart/form-data" name="editform">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <?
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    ?>
    <tr>
        <td class="adm-detail-content-cell-l">Название веб-сайта:</td>
        <td class="adm-detail-content-cell-r"><input type="text" name="SITE_NAME" size="30" value="<?= Option::get('boilerplate.module.menupage', 'SITE_NAME') ?>"></td>
    </tr>
    <?php
    $tabControl->EndTab();
    $tabControl->Buttons();
    // @todo fixit
    ?>
    <input class="adm-btn-save"
       type="submit" name="save"
       value="Сохранить"
       title="Сохранить" />
    <?php
    $tabControl->End();
    ?>
</form>
<?php
require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/epilog_admin.php');

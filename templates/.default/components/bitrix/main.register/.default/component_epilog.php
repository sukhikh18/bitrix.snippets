<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global $APPLICATION */

use Bitrix\Main;

$obContext = Main\Context::getCurrent();
$obServer = $obContext->getServer();
$obRequest = $obContext->getRequest();

if ('POST' === strtoupper($obServer->getRequestMethod()) && $obRequest->get('register_submit_button')) {
    @header('Content-Type: application/json');
    $APPLICATION->RestartBuffer();

    if (empty($arResult['ERRORS'])) {
        $arResponse = [
            'SUCCESS' => 'Y',
            'BACKURL' => $obRequest->get('backurl'),
        ];
    } else {
        $arResponse = [
            'SUCCESS' => 'N',
            'ERRORS' => $arResult['ERRORS'],
        ];
    }

    echo Main\Web\Json::encode($arResponse);
    die();
}

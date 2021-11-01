<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @global $APPLICATION */
/** @global $USER */

use Bitrix\Main;

$obRequest = Main\Context::getCurrent()->getRequest();

// Condition like a component
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["register_submit_button"] <> '' && !$USER->IsAuthorized()) {
    @header('Content-Type: application/json');
    $APPLICATION->RestartBuffer();

    if (empty($arResult['ERRORS'])) {
        $arResponse = [
            'SUCCESS' => 'Y',
            'SUCCESS_MESSAGE' => '@todo',
            'BACKURL' => $obRequest->get('backurl') ?: '',
            'CAPTCHA_HTML' => $arResult['CAPTCHA_HTML'],
        ];
    } else {
        $arResponse = [
            'SUCCESS' => 'N',
            'ERRORS' => $arResult['ERRORS'],
            'CAPTCHA_HTML' => $arResult['CAPTCHA_HTML'],
        ];
    }

    exit(Main\Web\Json::encode($arResponse));
}

if ('GET' === $_SERVER["REQUEST_METHOD"] && 'getCaptcha' === $obRequest->get('action')) {
    @header('Content-Type: application/json');
    $APPLICATION->RestartBuffer();

    exit(Main\Web\Json::encode([
        'CAPTCHA_HTML' => $arResult['CAPTCHA_HTML'],
    ]));
}

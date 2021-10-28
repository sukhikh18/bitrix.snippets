<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($cp = $this->getComponent()) {
    $cp->arResult['FORM_ERRORS'] = $arResult['FORM_ERRORS'];
    $cp->SetResultCacheKeys(['FORM_ERRORS']);
}

if (!function_exists('prepareAnswer')):
    function prepareAnswer(&$arAnswer, $i, $arQuestion) {
        $arAnswer['NAME'] = "form_{$arAnswer['FIELD_TYPE']}_{$arAnswer['ID']}";
        $arAnswer['REQUIRED'] = ('Y' !== $arQuestion['REQUIRED']) ? '' : ' required="true"';
    }
endif;

foreach ($arResult['arAnswers'] as $name => $arQuestion)
{
    array_walk($arResult['arAnswers'][$name], 'prepareAnswer', $arResult['arQuestions'][$name]);

}

$arResult['WEB_FORM_AREA_ID'] = $arParams['WEB_FORM_ID'] . '-' . \Bitrix\Main\Security\Random::getString(6);

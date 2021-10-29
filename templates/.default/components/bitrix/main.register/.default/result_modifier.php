<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

$this->getComponent()->SetResultCacheKeys(['ERRORS']);

// Sort fields by params.
$arResult["SHOW_FIELDS"] = array_unique(array_merge($arParams['SHOW_FIELDS'], $arResult["SHOW_FIELDS"] ?: [],
    array_keys($arResult["USER_PROPERTIES"]["DATA"] ?: [])));

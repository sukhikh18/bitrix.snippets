<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

$this->getComponent()->SetResultCacheKeys(['ERRORS', 'CAPTCHA_HTML']);

// Sort fields by params.
$arResult["SHOW_FIELDS"] = array_unique(array_merge($arParams['SHOW_FIELDS'], $arResult["SHOW_FIELDS"] ?: [],
    array_keys($arResult["USER_PROPERTIES"]["DATA"] ?: [])));

if ('Y' == $arResult["USE_CAPTCHA"]) {
    $captchaHtml = <<<HTML
        <label class="captcha-field-label">
            {{ REGISTER_CAPTCHA_PROMT }}
            <img src="/bitrix/tools/captcha.php?captcha_sid={{ CAPTCHA_CODE }}"
                 width="180" height="40" alt="CAPTCHA" />
        </label>
        <input type="hidden" name="captcha_sid" value="{{ CAPTCHA_CODE }}"/>
        <input type="text" name="captcha_word" maxlength="50" value="" class="form-control form-group-input"
               autocomplete="off"/>
    HTML;

    $captchaReplacements = [
        '{{ REGISTER_CAPTCHA_PROMT }}' => GetMessage("REGISTER_CAPTCHA_PROMT"),
        '{{ CAPTCHA_CODE }}' => $arResult["CAPTCHA_CODE"],
    ];

    $arResult['CAPTCHA_HTML'] = str_replace(array_keys($captchaReplacements), array_values($captchaReplacements), $captchaHtml);
}

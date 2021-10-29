<?php if ( ! defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

?>
<form class="form form-main-register" method="post" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="register_submit_button" value="1">
    <?php if (mb_strlen($arResult["BACKURL"]) > 0): ?>
        <input type="hidden" name="backurl" value="<?= $arResult['BACKURL'] ?>" />
    <?php endif ?>

    <div class="form-errors" data-entity="error-messages">
        <?php

        if (count($arResult["ERRORS"]) > 0) {
            foreach ($arResult["ERRORS"] as $key => $error) {
                if (intval($key) == 0 && $key !== 0) {
                    $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#",
                        "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);
                }
            }

            ShowError(implode("<br />", $arResult["ERRORS"]));
        }

        ?>
    </div>

    <?php
    foreach ($arResult["SHOW_FIELDS"] as $FIELD) {
        switch ($FIELD) {
            case 'LOGIN':
                ?>
                <div class="form-group mb-3 form-group--login">
                    <label class="form-group-label">Введите ваш новый логин</label>
                    <input class="form-control form-group-input" type="text" placeholder="Логин" name="REGISTER[LOGIN]"
                        value="<?= $arResult["VALUES"]["LOGIN"] ?>" autocomplete="login" />
                </div>
                <?php
                break;

            case 'NAME':
                ?>
                <div class="form-group mb-3 form-group--name">
                    <label class="form-group-label">Введите ваше имя</label>
                    <input class="form-control form-group-input" type="text" placeholder="Ф.И.О." name="REGISTER[NAME]"
                        value="<?= $arResult["VALUES"]["NAME"] ?>" autocomplete="name" />
                </div>
                <?php
                break;

            case 'PERSONAL_PHONE':
                ?>
                <div class="form-group mb-3 form-group--personal_phone">
                    <label class="form-group-label">Введите ваш номер телефона</label>
                    <input class="form-control form-group-input" type="tel" placeholder="Номер телефона" name="REGISTER[PERSONAL_PHONE]"
                        value="<?= $arResult["VALUES"]["PERSONAL_PHONE"] ?>" autocomplete="tel" />
                </div>
                <?php
                break;

            case 'EMAIL':
                ?>
                <div class="form-group mb-3 form-group--email">
                    <label class="form-group-label">Введите ваш Email</label>
                    <input class="form-control form-group-input" type="text" placeholder="Электронная почта" name="REGISTER[EMAIL]"
                        value="<?= $arResult["VALUES"]["EMAIL"] ?>" autocomplete="email" required="true" />
                </div>
                <?php
                break;

            case 'USER_PROPERTIES':
            foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField) {
                // @todo 'string' == ['USER_TYPE']['USER_TYPE_ID']
                /*$APPLICATION->IncludeComponent(
                "bitrix:system.field.edit",
                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));*/
                ?>
                <div class="form-group mb-3 form-group--<?= strtolower($FIELD_NAME) ?>">
                    <label class="form-group-label"><?= $arUserField['EDIT_FORM_LABEL'] ?></label>
                    <?php
                    if('UF_CITY' === $FIELD_NAME) {
                        /** @var Bitrix\Main\ORM\Query\Result $resCities [description] */
                        $resCities = \Bitrix\Sale\Location\LocationTable::getList(array(
                            'filter' => array(
                                '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                                '=TYPE_CODE' => 'CITY',
                            ),
                            'select' => array(
                                'ID' => 'ID',
                                'NAME_RU' => 'NAME.NAME',
                                'TYPE_CODE' => 'TYPE.CODE',
                            )
                        ));

                        echo '<select name="'. $FIELD_NAME .'" class="form-control form-group-input">';
                        echo "<option></option>";

                        /** @var array $arCity ['ID', 'NAME_RU', 'TYPE_CODE'] */
                        while ($arCity = $resCities->fetch()) {
                            echo "<option value=\"{$arCity['ID']}:{$arCity['NAME_RU']}\">{$arCity['NAME_RU']}</option>";
                        }

                        echo '</select>';
                    } else {
                        ?>
                        <input type="text" name="<?= $FIELD_NAME ?>" value="<?= $arResult["VALUES"][$FIELD_NAME] ?>" class="form-control form-group-input">
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
                break;

            case 'PASSWORD':
                ?>
                <div class="form-group mb-3 form-group--password">
                    <label class="form-group-label">Введите ваш новый пароль</label>
                    <input type="password" placeholder="Пароль" name="REGISTER[PASSWORD]" class="form-control form-group-input"
                        value="<?= $arResult["VALUES"]["PASSWORD"] ?>" style="background: inherit;"
                        autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly />
                </div>
                <?php
                break;

            case 'CONFIRM_PASSWORD':
                if ($arParams['CONFIRM_PASSWORD']) {
                } else {
                ?>
                <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" class="form-control form-group-input" autocomplete="off"
                    value="<?= $arResult["VALUES"]["CONFIRM_PASSWORD"] ?: '1' ?>" readonly />
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof window.cloneValue === 'function') {
                            window.clonePwd('[name="REGISTER[PASSWORD]"]', '[name="REGISTER[CONFIRM_PASSWORD]"]')
                        }
                    };
                </script>
                <?php
                }
                break;

            default:
                ?>
                <div class="form-group">
                    <input type="text" class="form-control form-group-input" name="REGISTER[<?= $FIELD ?>]"
                        value="<?= $arResult["VALUES"][$FIELD] ?>" />
                </div>
                <?php
                break;
        }
    }

    ?>
    <?php if ('Y' == $arResult["USE_CAPTCHA"]) : ?>
        <div class="form-group mb-3 form-group--captcha">
            <label class="d-flex align-items-center justify-content-between mb-1"><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>:
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                     width="180" height="40" alt="CAPTCHA"/>
            </label>
            <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
            <input type="text" name="captcha_word" maxlength="50" value="" class="form-control form-group-input" autocomplete="off" />
        </div>
    <?php endif; ?>

    <div class="form-helpers">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="privacy_accept" value="Y" checked>
                <span class="form-check-label">
                    Нажимая кнопку "Зарегистрироваться", я подтверждаю, что я ознакомился с
                    <a href="<?= $arParams['PRIVACY_LINK'] ?>" target="_blank">политикой обработки персональных данных</a>
                    и даю согласие на обработку мои персональных данных
                </span>
            </label>
        </div>
    </div>

    <div class="submit-wrap mt-2 mb-2">
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </div>

    <div class="form-success">
        <?php

        if ('Y' === $arResult["USE_EMAIL_CONFIRMATION"] && count($arResult["ERRORS"]) === 0) {
            echo '<p>' . GetMessage("REGISTER_EMAIL_WILL_BE_SENT") . '</p>';
        }

        ?>
    </div>
</form>
<p class="text-center">
    <a class="login" href="/auth/?login=yes" rel="nofollow">Уже зарегистрированы? Войти</a>
</p>

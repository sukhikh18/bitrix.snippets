<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined('REQUIRED_STAR')) define('REQUIRED_STAR', '<span class="text-danger">*</span>');

?>
<form class="form form-main-register" method="post" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data"
      novalidate>
    <input type="hidden" name="register_submit_button" value="1">
    <?php if (mb_strlen($arResult["BACKURL"]) > 0): ?>
        <input type="hidden" name="backurl" value="<?= $arResult['BACKURL'] ?>"/>
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
        $isRequired = $isRequired;

        switch ($FIELD) {
        case 'LOGIN':
            ?>
            <div class="form-group mb-3 form-group--login">
                <label class="form-group-label"><?= GetMessage("REGISTER_FIELD_LOGIN_LABEL") ?><?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="text"
                       placeholder="<?= GetMessage("REGISTER_FIELD_LOGIN") ?>" name="REGISTER[LOGIN]"
                       value="<?= $arResult["VALUES"]["LOGIN"] ?>"
                       autocomplete="login"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php
        break;

        case 'NAME':
        ?>
            <div class="form-group mb-3 form-group--name">
                <label class="form-group-label"><?= GetMessage("REGISTER_FIELD_NAME_LABEL") ?><?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="text"
                       placeholder="<?= GetMessage("REGISTER_FIELD_NAME") ?>" name="REGISTER[NAME]"
                       value="<?= $arResult["VALUES"]["NAME"] ?>"
                       autocomplete="name"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php
        break;

        case 'PERSONAL_PHONE':
        ?>
            <div class="form-group mb-3 form-group--personal_phone">
                <label class="form-group-label"><?= GetMessage("REGISTER_FIELD_PERSONAL_PHONE_LABEL") ?><?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="tel"
                       placeholder="<?= GetMessage("REGISTER_FIELD_PERSONAL_PHONE") ?>" name="REGISTER[PERSONAL_PHONE]"
                       value="<?= $arResult["VALUES"]["PERSONAL_PHONE"] ?>"
                       autocomplete="tel"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php
        break;

        case 'EMAIL':
        ?>
            <div class="form-group mb-3 form-group--email">
                <label class="form-group-label"><?= GetMessage("REGISTER_FIELD_EMAIL_LABEL") ?><?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="text"
                       placeholder="<?= GetMessage("REGISTER_FIELD_EMAIL") ?>" name="REGISTER[EMAIL]"
                       value="<?= $arResult["VALUES"]["EMAIL"] ?>"
                       autocomplete="email"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php
        break;

        case 'PASSWORD':
        ?>
            <div class="form-group mb-3 form-group--password">
                <label class="form-group-label">Введите ваш новый пароль<?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="password" placeholder="Пароль"
                       name="REGISTER[PASSWORD]"
                       value="<?= $arResult["VALUES"]["PASSWORD"] ?>"
                       style="background: inherit;"<?= $isRequired ? ' required' : '' ?>
                       autocomplete="off" onfocus="this.removeAttribute('readonly');" readonly/>
            </div>
        <?php
        break;

        case 'CONFIRM_PASSWORD':
        if ($arParams['CONFIRM_PASSWORD']) {
        } else {
        ?>
        <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" class="form-control form-group-input" autocomplete="off"
               value="<?= $arResult["VALUES"]["CONFIRM_PASSWORD"] ?: '1' ?>"
               readonly<?= $isRequired ? ' required' : '' ?> />
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof window.cloneValue === 'function') {
                        window.cloneValue('[name="REGISTER[PASSWORD]"]', '[name="REGISTER[CONFIRM_PASSWORD]"]')
                    }
                };
            </script>
        <?php
        }
        break;

        default:
        if ($arUserField = ($arResult["USER_PROPERTIES"]["DATA"][$FIELD] ?? false)): ?>
            <div class="form-group mb-3 form-group--<?= mb_strtolower($FIELD) ?>">
                <label class="form-group-label"><?= $arUserField['EDIT_FORM_LABEL'] ?><?= $isRequired ? REQUIRED_STAR : '' ?></label>
                <input class="form-control form-group-input" type="text" name="<?= $FIELD ?>"
                       value="<?= $arResult["VALUES"][$FIELD] ?>"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php else: ?>
            <div class="form-group mb-3 form-group--<?= mb_strtolower($FIELD) ?>">
                <div class="form-group-label"><?= GetMessage("REGISTER_FIELD_{$FIELD}") ?><?= $isRequired ? REQUIRED_STAR : '' ?></div>
                <input class="form-control form-group-input" type="text" name="REGISTER[<?= $FIELD ?>]"
                       value="<?= $arResult["VALUES"][$FIELD] ?>"<?= $isRequired ? ' required' : '' ?> />
            </div>
        <?php endif;
            break;
        }
    }

    ?>
    <?php if ('Y' == $arResult["USE_CAPTCHA"]) : ?>
        <div class="form-group mb-3 form-group--captcha">
            <label class="d-flex align-items-center justify-content-between mb-1"><?= GetMessage("REGISTER_CAPTCHA_PROMT") ?>
                :
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                     width="180" height="40" alt="CAPTCHA"/>
            </label>
            <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
            <input type="text" name="captcha_word" maxlength="50" value="" class="form-control form-group-input"
                   autocomplete="off"/>
        </div>
    <?php endif; ?>

    <div class="form-helpers">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="privacy_accept" value="Y" checked>
                <span class="form-check-label">
                    Нажимая кнопку "Зарегистрироваться", я подтверждаю, что я ознакомился с
                    <a href="<?= $arParams['PRIVACY_LINK'] ?>"
                       target="_blank">политикой обработки персональных данных</a>
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

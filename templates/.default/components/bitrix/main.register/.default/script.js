/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************************************!*\
  !*** ./assets/components/bitrix/main.register/.default/script.js ***!
  \*******************************************************************/
document.addEventListener('DOMContentLoaded', function () {
  var formEl = document.querySelector('.form-main-register');
  if (!formEl) return;
  var submitEl = formEl.querySelector('[type="submit"]');
  !formEl || formEl.querySelector('[name="privacy_accept"]').addEventListener('input', function (e) {
    if (e.target.checked) {
      submitEl.classList.remove('disabled');
      submitEl.removeAttribute('disabled');
    } else {
      submitEl.classList.add('disabled');
      submitEl.setAttribute('disabled', 'true');
    }
  });

  window.cloneValue = function (passwordSelector, confirmSelector) {
    var password = form.querySelector(passwordSelector);
    var confirm = form.querySelector(confirmSelector);

    if (password && confirm) {
      password.addEventListener('keyup', function (e) {
        confirm.value = e.target.value;
      });
      confirm.removeAttribute('readonly');
    }
  };
});
/******/ })()
;
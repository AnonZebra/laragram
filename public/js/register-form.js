/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/register-form.js ***!
  \***************************************/


var password1 = document.getElementById('password');
var password2 = document.getElementById('password_confirmation');
var regForm = document.getElementById('register-form');
[password1, password2].forEach(function (el) {
  return el.addEventListener('input', passwordCheck);
});

function passwordCheck() {
  if (!password2.value) {
    password2.classList.remove('incorrect');
  } else if (password2.value === password1.value) {
    password2.classList.remove('incorrect');
    password2.classList.add('correct');
  } else {
    password2.classList.remove('correct');
    password2.classList.add('incorrect');
  }
}

regForm.addEventListener('submit', function (e) {});
/******/ })()
;
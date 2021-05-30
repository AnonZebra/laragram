/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/register-form.js ***!
  \***************************************/


var password1 = document.getElementById('password');
var password2 = document.getElementById('password-repeat');
password2.addEventListener('input', function (e) {
  console.log('password1', password1.value);
  console.log('password2', password2.value);

  if (password2.value === password1.value) {
    password2.classList.remove('incorrect');
    password2.classList.add('correct');
  } else {
    password2.classList.remove('correct');
    password2.classList.add('incorrect');
  }
});
/******/ })()
;
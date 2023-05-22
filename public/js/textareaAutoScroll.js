/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/textareaAutoScroll.js ***!
  \********************************************/
var textarea = document.querySelector("textarea");
textarea.addEventListener("keyup", function (e) {
  textarea.style.height = '100px';
  var scHeight = e.target.scrollHeight;
  textarea.style.height = scHeight + 'px';
});
/******/ })()
;
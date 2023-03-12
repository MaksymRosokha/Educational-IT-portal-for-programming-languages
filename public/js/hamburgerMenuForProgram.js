/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./resources/js/hamburgerMenuForProgram.js ***!
  \*************************************************/
var programContent = document.querySelector('.program__content');
var hamburgerMenu = document.querySelector('.hamburger-menu');
var listOfLessons = document.querySelector('.list-of-lessons');
var lessons = document.getElementsByClassName('lesson');
var title = document.querySelector('.list-of-lessons__title');
var linkToProgram = document.querySelector('.link-to-program');
hamburgerMenu.addEventListener("click", function (event) {
  hamburgerMenu.classList.toggle('hamburger-menu--hid-content');
  programContent.classList.toggle('program__content--showed-content');
  listOfLessons.classList.toggle('list-of-lessons--hid-content');
  if (title.style.display === "none") {
    title.style.display = "block";
    linkToProgram.style.display = "block";
    for (var i = 0; i < lessons.length; i++) {
      lessons[i].style.display = "flex";
    }
  } else {
    title.style.display = "none";
    linkToProgram.style.display = "none";
    for (var _i = 0; _i < lessons.length; _i++) {
      lessons[_i].style.display = "none";
    }
  }
});
/******/ })()
;
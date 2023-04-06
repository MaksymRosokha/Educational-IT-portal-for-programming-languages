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
var mediaQueryMaxWidth600 = window.matchMedia('(max-width: 600px)');
var mediaQueryMinWidth600 = window.matchMedia('(min-width: 600px)');
document.addEventListener("DOMContentLoaded", function () {
  toggleHamburgerMenu();
});
hamburgerMenu.addEventListener("click", toggleHamburgerMenu);
mediaQueryMaxWidth600.addListener(function (e) {
  if (e.matches) {
    if (title.style.display !== "none") {
      toggleHamburgerMenu();
    }
  }
});
mediaQueryMinWidth600.addListener(function (e) {
  if (e.matches) {
    if (title.style.display !== "none") {
      toggleHamburgerMenu();
    }
  }
});
function toggleHamburgerMenu() {
  hamburgerMenu.classList.toggle('hamburger-menu--hid-content');
  listOfLessons.classList.toggle('list-of-lessons--hid-content');
  if (title.style.display === "none") {
    title.style.display = "block";
    linkToProgram.style.display = "block";
    if (mediaQueryMaxWidth600.matches) {
      programContent.style.display = "none";
    }
    for (var i = 0; i < lessons.length; i++) {
      lessons[i].style.display = "flex";
    }
  } else {
    title.style.display = "none";
    linkToProgram.style.display = "none";
    if (mediaQueryMaxWidth600.matches || mediaQueryMinWidth600.matches) {
      programContent.style.display = "flex";
    }
    for (var _i = 0; _i < lessons.length; _i++) {
      lessons[_i].style.display = "none";
    }
  }
}
/******/ })()
;
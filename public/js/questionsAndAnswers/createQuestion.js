/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************************!*\
  !*** ./resources/js/questionsAndAnswers/createQuestion.js ***!
  \************************************************************/
var createQuestionButton = document.getElementById('create-question');
var title = document.getElementById('title');
var description = document.getElementById('description');
var questionsBlock = document.querySelector('.questions-and-answers__questions');
var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
createQuestionButton.addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/question_create");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      questionsBlock.innerHTML = xhr.response;
      title.value = '';
      description.value = '';
    } else if (xhr.readyState === 4) {
      alert('Не вдалося створити запитання');
    }
  };
  xhr.send("title=" + title.value + "&description=" + description.value + "&_token=" + csrf);
});
/******/ })()
;
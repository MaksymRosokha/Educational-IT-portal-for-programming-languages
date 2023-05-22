/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/questionsAndAnswers/answer.js ***!
  \****************************************************/
var createAnswer = document.getElementById('create-answer');
var text = document.getElementById('text');
var answersBlock = document.querySelector('.answers');
var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var questionID = createAnswer.getAttribute('data-question-id');
createAnswer.addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/answer_create");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      answersBlock.innerHTML = xhr.response;
      text.value = '';
    } else if (xhr.readyState === 4) {
      alert('Не вдалося відповісти');
    }
  };
  xhr.send("question_id=" + questionID + "&text=" + text.value + "&_token=" + csrf);
});
/******/ })()
;
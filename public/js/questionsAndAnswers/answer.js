/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/questionsAndAnswers/answer.js ***!
  \****************************************************/
var createAnswer = document.getElementById('create-answer');
var text = document.getElementById('text');
var answersBlock = document.querySelector('.answers');
var questionID = createAnswer.getAttribute('data-question-id');
var search = document.getElementById('search-text');
var isOnlyMyQuestions = document.getElementById('only-my');
var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
isOnlyMyQuestions.addEventListener('change', function () {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/only_my_answers");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      answersBlock.innerHTML = xhr.response;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося виконати');
    }
  };
  xhr.send("isOnlyMy=" + isOnlyMyQuestions.checked + "&question_id=" + questionID + "&_token=" + csrf);
});
search.addEventListener("input", function (event) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/search_answers");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      answersBlock.innerHTML = xhr.response;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося виконати пошук');
    }
  };
  xhr.send("searchText=" + event.target.value + "&isOnlyMy=" + isOnlyMyQuestions.checked + "&question_id=" + questionID + "&_token=" + csrf);
});
/******/ })()
;
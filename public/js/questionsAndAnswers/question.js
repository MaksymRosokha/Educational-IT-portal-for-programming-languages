/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./resources/js/questionsAndAnswers/question.js ***!
  \******************************************************/
var questionsBlock = document.querySelector('.questions-and-answers__questions');
var search = document.getElementById('search-text');
var isOnlyMyQuestions = document.getElementById('only-my');
var countOfQuestions = document.querySelectorAll('.question').length;
var isLoaded = true;
var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
isOnlyMyQuestions.addEventListener('change', function () {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/only_my_questions");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      questionsBlock.innerHTML = xhr.response;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося вибрати тільки ваші питання. Можливо ви не авторизовані?');
    }
  };
  xhr.send("isOnlyMy=" + isOnlyMyQuestions.checked + "&_token=" + csrf);
});
search.addEventListener("input", function (event) {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/search_questions");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      questionsBlock.innerHTML = xhr.response;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося виконати пошук');
    }
  };
  xhr.send("searchText=" + event.target.value + "&isOnlyMy=" + isOnlyMyQuestions.checked + "&_token=" + csrf);
});
window.addEventListener("scroll", function () {
  var body = document.body;
  var html = document.documentElement;
  var height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
  var userBottom = html.scrollTop - (html.clientTop || 0) + html.clientHeight;
  var difference = 500;
  if (isLoaded) {
    if (height - userBottom < difference) {
      isLoaded = false;
      loadMoreQuestions();
    }
  }
});
function loadMoreQuestions() {
  countOfQuestions += 10;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/load_more_questions");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      questionsBlock.innerHTML = xhr.response;
      isLoaded = true;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося завантажити питання');
    }
  };
  xhr.send("limit=" + countOfQuestions + "&searchText=" + search.value + "&isOnlyMy=" + isOnlyMyQuestions.checked + "&_token=" + csrf);
}
/******/ })()
;
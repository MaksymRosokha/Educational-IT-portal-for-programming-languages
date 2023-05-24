/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/questionsAndAnswers/answer.js ***!
  \****************************************************/
var answersBlock = document.querySelector('.answers');
var questionID = document.querySelector('.question__title').getAttribute('data-question-id');
var search = document.getElementById('search-text');
var isOnlyMyAnswers = document.getElementById('only-my');
var countOfAnswers = document.querySelectorAll('.answer').length;
var isLoaded = true;
var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
isOnlyMyAnswers.addEventListener('change', function () {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/only_my_answers");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      answersBlock.innerHTML = xhr.response;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося вибрати тільки ваші відовіді. Можливо ви не авторизовані?');
    }
  };
  xhr.send("isOnlyMy=" + isOnlyMyAnswers.checked + "&question_id=" + questionID + "&_token=" + csrf);
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
  xhr.send("searchText=" + event.target.value + "&isOnlyMy=" + isOnlyMyAnswers.checked + "&question_id=" + questionID + "&_token=" + csrf);
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
      loadMoreAnswers();
    }
  }
});
function loadMoreAnswers() {
  countOfAnswers += 10;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "/load_more_answers");
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      answersBlock.innerHTML = xhr.response;
      isLoaded = true;
    } else if (xhr.readyState === 4) {
      alert('Не вдалося завантажити більше відповідей');
    }
  };
  console.log("limit=" + countOfAnswers + "&searchText=" + search.value + "&isOnlyMy=" + isOnlyMyAnswers.checked + "&question_id=" + questionID + "&_token=" + csrf);
  xhr.send("limit=" + countOfAnswers + "&searchText=" + search.value + "&isOnlyMy=" + isOnlyMyAnswers.checked + "&question_id=" + questionID + "&_token=" + csrf);
}
/******/ })()
;
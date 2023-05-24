const createAnswer = document.getElementById('create-answer');
const text = document.getElementById('text');
const answersBlock = document.querySelector('.answers');
let questionID = createAnswer.getAttribute('data-question-id');

const search = document.getElementById('search-text');
const isOnlyMyQuestions = document.getElementById('only-my');

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

createAnswer.addEventListener("click", e => {
    e.preventDefault();
    e.stopPropagation();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/answer_create");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
            text.value = '';
        } else if (xhr.readyState === 4) {
            alert('Не вдалося відповісти')
        }
    };
    xhr.send(
        "question_id=" + questionID +
        "&text=" + text.value +
        "&_token=" + csrf
    );
});


isOnlyMyQuestions.addEventListener('change', function () {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/only_my_answers");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося виконати')
        }
    };

    xhr.send(
        "isOnlyMy=" + isOnlyMyQuestions.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf
    );
});

search.addEventListener("input", (event) => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/search_answers");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося виконати пошук')
        }
    };

    xhr.send(
        "searchText=" + event.target.value +
        "&isOnlyMy=" + isOnlyMyQuestions.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf
    );
});
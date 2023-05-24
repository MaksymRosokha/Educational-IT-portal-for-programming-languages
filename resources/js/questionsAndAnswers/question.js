const createQuestionButton = document.getElementById('create-question');
const title = document.getElementById('title');
const description = document.getElementById('description');
const questionsBlock = document.querySelector('.questions-and-answers__questions');

const search = document.getElementById('search-text');
const isOnlyMyQuestions = document.getElementById('only-my');

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

createQuestionButton.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/question_create");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            questionsBlock.innerHTML = xhr.response;
            title.value = '';
            description.value = '';
        } else if (xhr.readyState === 4) {
            alert('Не вдалося створити запитання')
        }
    };
    xhr.send(
        "title=" + title.value +
        "&description=" + description.value +
        "&_token=" + csrf
    );
});

isOnlyMyQuestions.addEventListener('change', function () {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/only_my_questions");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            questionsBlock.innerHTML = xhr.response;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося виконати')
        }
    };

    xhr.send("isOnlyMy=" + isOnlyMyQuestions.checked + "&_token=" + csrf);
});

search.addEventListener("input", (event) => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/search_questions");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            questionsBlock.innerHTML = xhr.response;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося виконати пошук')
        }
    };

    xhr.send(
        "searchText=" + event.target.value +
        "&isOnlyMy=" + isOnlyMyQuestions.checked +
        "&_token=" + csrf
    );
});
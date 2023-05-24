const answersBlock = document.querySelector('.answers');
let questionID = document.querySelector('.question__title').getAttribute('data-question-id');

const search = document.getElementById('search-text');
const isOnlyMyAnswers = document.getElementById('only-my');

let countOfAnswers = document.querySelectorAll('.answer').length;
let isLoaded = true;

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


isOnlyMyAnswers.addEventListener('change', function () {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/only_my_answers");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося вибрати тільки ваші відовіді. Можливо ви не авторизовані?')
        }
    };

    xhr.send(
        "isOnlyMy=" + isOnlyMyAnswers.checked +
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
        "&isOnlyMy=" + isOnlyMyAnswers.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf
    );
});

window.addEventListener("scroll", () => {
    let body = document.body;
    let html = document.documentElement;

    let height = Math.max(body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight);
    let userBottom = html.scrollTop - (html.clientTop || 0) + html.clientHeight;

    const difference = 500;

    if (isLoaded) {
        if (height - userBottom < difference) {
            isLoaded = false;
            loadMoreAnswers();
        }
    }
});

function loadMoreAnswers() {
    countOfAnswers += 10;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/load_more_answers");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
            isLoaded = true;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося завантажити більше відповідей')
        }
    };
    console.log("limit=" + countOfAnswers +
        "&searchText=" + search.value +
        "&isOnlyMy=" + isOnlyMyAnswers.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf)

    xhr.send(
        "limit=" + countOfAnswers +
        "&searchText=" + search.value +
        "&isOnlyMy=" + isOnlyMyAnswers.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf
    );
}
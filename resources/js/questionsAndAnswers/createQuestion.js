const createQuestionButton = document.getElementById('create-question');
const title = document.getElementById('title');
const description = document.getElementById('description');
const questionsBlock = document.querySelector('.questions-and-answers__questions');
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
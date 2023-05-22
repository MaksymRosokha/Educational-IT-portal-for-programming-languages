const createAnswer = document.getElementById('create-answer');
const text = document.getElementById('text');
const answersBlock = document.querySelector('.answers');
let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let questionID = createAnswer.getAttribute('data-question-id');

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
import {createApp} from 'vue';
import UIComponents from "../components/UI/index";
import questionsAndAnswersComponents from "../components/questionsAndAnswers/index";


const answersBlock = document.querySelector('.answers');
let questionID = document.querySelector('.question__title').getAttribute('data-question-id');

const search = document.getElementById('search-text');
const isOnlyMyAnswers = document.getElementById('only-my');

let countOfAnswers = document.querySelectorAll('.answer').length;
let isLoaded = true;

let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

loadVueComponents();

export function loadVueComponents() {
    let updateButtons = document.querySelectorAll('.update-answer-button');
    let deleteButtons = document.querySelectorAll('.delete-answer-button');


    updateButtons.forEach((element) => {
        element.addEventListener('click', () => {
            let answerID = parseInt(element.getAttribute('data-answer'));
            let modalWindow = document.getElementById('update-modal-window-' + answerID);

            if (modalWindow.__vue_app__) {
                modalWindow.__vue_app__.unmount();
            }

            modalWindow.innerHTML = "<modal-window-with-auto-close " +
                "                  title=\"Редагування відповіді\" >" +
                "<answer-updater link=\"/answer_update\" " +
                "                id=\"" + answerID + "\"> " +
                "</answer-updater>" +
                "    </modal-window-with-auto-close>";

            const newApp = createApp({});
            UIComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            questionsAndAnswersComponents.forEach(component => {
                newApp.component(component.name, component);
            });

            newApp.mount(modalWindow);
        });
    });

    deleteButtons.forEach((element) => {
        element.addEventListener('click', () => {
            let answerID = parseInt(element.getAttribute('data-answer'));
            let modalWindow = document.getElementById('delete-modal-window-' + answerID);

            if (modalWindow.__vue_app__) {
                modalWindow.__vue_app__.unmount();
            }

            modalWindow.innerHTML = "<modal-window-with-auto-close " +
                "                  title=\"Видалення відповіді\" >" +
                "<delete-confirmation link=\"/answer_delete\" " +
                "                id=\"" + answerID + "\"> " +
                "</delete-confirmation>" +
                "    </modal-window-with-auto-close>";

            const newApp = createApp({});
            UIComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            questionsAndAnswersComponents.forEach(component => {
                newApp.component(component.name, component);
            });

            newApp.mount(modalWindow);
        });
    });

}

isOnlyMyAnswers.addEventListener('change', function () {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/only_my_answers");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            answersBlock.innerHTML = xhr.response;
            loadVueComponents();
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
            loadVueComponents();
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
            loadVueComponents();
            isLoaded = true;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося завантажити більше відповідей')
        }
    };

    xhr.send(
        "limit=" + countOfAnswers +
        "&searchText=" + search.value +
        "&isOnlyMy=" + isOnlyMyAnswers.checked +
        "&question_id=" + questionID +
        "&_token=" + csrf
    );
}
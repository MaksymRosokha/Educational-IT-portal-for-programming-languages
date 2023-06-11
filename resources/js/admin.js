import {createApp} from 'vue';
import UIComponents from "./components/UI/index";
import adminComponents from "./components/admin/index";
import userComponents from "./components/user/index";

const usersBlock = document.querySelector('.users');
const search = document.getElementById('search-text');

let roleSelectors = document.getElementsByClassName('role__selector');
let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let countOfUsers = document.querySelectorAll('.user').length;
let isLoaded = true;


loadVueComponents();

function loadVueComponents() {
    let blockButtons = document.querySelectorAll('.block-user-button');
    let unlockButtons = document.querySelectorAll('.unlock-user-button');
    let deleteButtons = document.querySelectorAll('.delete-user-button');

    setRoles();

    blockButtons.forEach((element) => {
        element.addEventListener('click', () => {
            let userID = parseInt(element.getAttribute('data-user'));
            let modalWindow = document.getElementById('block-user-modal-window-' + userID);

            if (modalWindow.__vue_app__) {
                modalWindow.__vue_app__.unmount();
            }

            modalWindow.innerHTML = "<modal-window-with-auto-close " +
                "                  title=\"Блокування користувача\" >" +
                "<user-blocker link=\"/admin/block_user\" " +
                "id=\"" + userID + "\">" +
                "</user-blocker>" +
                "    </modal-window-with-auto-close>";

            const newApp = createApp({});
            UIComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            adminComponents.forEach(component => {
                newApp.component(component.name, component);
            });

            newApp.mount(modalWindow);
        });
    });

    unlockButtons.forEach((element) => {
        element.addEventListener('click', () => {
            let userID = parseInt(element.getAttribute('data-user'));
            let modalWindow = document.getElementById('unlock-user-modal-window-' + userID);

            if (modalWindow.__vue_app__) {
                modalWindow.__vue_app__.unmount();
            }

            modalWindow.innerHTML = "<modal-window-with-auto-close " +
                "                  title=\"Розблокування користувача\" >" +
                "<user-unlocker link=\"/admin/unlock_user\" " +
                "id=\"" + userID + "\">" +
                "</user-unlocker>" +
                "    </modal-window-with-auto-close>";

            const newApp = createApp({});
            UIComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            adminComponents.forEach(component => {
                newApp.component(component.name, component);
            });

            newApp.mount(modalWindow);
        });
    });

    deleteButtons.forEach((element) => {
        element.addEventListener('click', () => {
            let userID = parseInt(element.getAttribute('data-user'));
            let modalWindow = document.getElementById('delete-user-modal-window-' + userID);

            if (modalWindow.__vue_app__) {
                modalWindow.__vue_app__.unmount();
            }

            modalWindow.innerHTML = "<modal-window-with-auto-close " +
                "                  title=\"Видалення користувача\" >" +
                "<user-deleter link=\"/delete_user\" " +
                "id=\"" + userID + "\">" +
                "</user-deleter>" +
                "    </modal-window-with-auto-close>";


            const newApp = createApp({});
            UIComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            adminComponents.forEach(component => {
                newApp.component(component.name, component);
            });
            userComponents.forEach(component => {
                newApp.component(component.name, component);
            });

            newApp.mount(modalWindow);
        });
    });

}

function setRoles() {
    Array.from(roleSelectors).forEach(function (element) {
        element.addEventListener('change', function (event) {
            let userID = element.getAttribute('data-user-id');

            let xhr = new XMLHttpRequest();
            xhr.open('POST', "/admin/change_role");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Роль успішно змінена');
                } else if (xhr.readyState === 4) {
                    alert('Не вдалося змінити роль');
                }
            };
            xhr.send("id=" + userID + '&role=' + event.target.value + '&_token=' + csrf);
        });
    });
}

search.addEventListener("input", (event) => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/admin/search");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            usersBlock.innerHTML = xhr.response;
            loadVueComponents();
        } else if (xhr.readyState === 4) {
            alert('Не вдалося виконати пошук')
        }
    };

    xhr.send("searchText=" + event.target.value + "&_token=" + csrf);
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
            loadMoreUsers();
        }
    }
});

function loadMoreUsers() {
    countOfUsers += 20;

    let xhr = new XMLHttpRequest();
    xhr.open('POST', "/admin/load_more_users");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            usersBlock.innerHTML = xhr.response;
            loadVueComponents();
            isLoaded = true;
        } else if (xhr.readyState === 4) {
            alert('Не вдалося завантажити більше користувачів')
        }
    };

    xhr.send(
        "limit=" + countOfUsers +
        "&searchText=" + search.value +
        "&_token=" + csrf
    );
}
let roleSelectors = document.getElementsByClassName('role__selector');
let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

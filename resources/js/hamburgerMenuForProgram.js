let programContent = document.querySelector('.program__content');
let hamburgerMenu = document.querySelector('.hamburger-menu');
let listOfLessons = document.querySelector('.list-of-lessons');
let lessons = document.getElementsByClassName('lesson');
let title = document.querySelector('.list-of-lessons__title');
let linkToProgram = document.querySelector('.link-to-program');

hamburgerMenu.addEventListener("click", (event) => {
    hamburgerMenu.classList.toggle('hamburger-menu--hid-content');
    programContent.classList.toggle('program__content--showed-content');
    listOfLessons.classList.toggle('list-of-lessons--hid-content');

    if(title.style.display === "none"){
        title.style.display = "block";
        linkToProgram.style.display = "block";
        for (let i = 0; i < lessons.length; i++){
            lessons[i].style.display = "flex";
        }
    } else {
        title.style.display = "none";
        linkToProgram.style.display = "none";
        for (let i = 0; i < lessons.length; i++){
            lessons[i].style.display = "none";
        }
    }
});
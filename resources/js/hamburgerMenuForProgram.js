let programContent = document.querySelector('.program__content');
let hamburgerMenu = document.querySelector('.hamburger-menu');
let listOfLessons = document.querySelector('.list-of-lessons');
let lessons = document.getElementsByClassName('lesson');
let title = document.querySelector('.list-of-lessons__title');
let linkToProgram = document.querySelector('.link-to-program');
const mediaQueryMaxWidth600 = window.matchMedia('(max-width: 600px)');
const mediaQueryMinWidth600 = window.matchMedia('(min-width: 600px)');

document.addEventListener("DOMContentLoaded", function(){
    toggleHamburgerMenu();
});
hamburgerMenu.addEventListener("click", toggleHamburgerMenu);

mediaQueryMaxWidth600.addListener((e) => {
    if (e.matches) {
        if(title.style.display !== "none"){
            toggleHamburgerMenu();
        }
    }
});

mediaQueryMinWidth600.addListener((e) => {
    if (e.matches) {
        if(title.style.display !== "none"){
            toggleHamburgerMenu();
        }
    }
});

function toggleHamburgerMenu(){
    hamburgerMenu.classList.toggle('hamburger-menu--hid-content');
    listOfLessons.classList.toggle('list-of-lessons--hid-content');

    if(title.style.display === "none"){
        title.style.display = "block";
        linkToProgram.style.display = "block";
        if(mediaQueryMaxWidth600.matches) {
            programContent.style.display = "none";
        }
        for (let i = 0; i < lessons.length; i++){
            lessons[i].style.display = "flex";
        }
    } else {
        title.style.display = "none";
        linkToProgram.style.display = "none";
        if(mediaQueryMaxWidth600.matches || mediaQueryMinWidth600.matches) {
            programContent.style.display = "flex";
        }
        for (let i = 0; i < lessons.length; i++){
            lessons[i].style.display = "none";
        }
    }
}
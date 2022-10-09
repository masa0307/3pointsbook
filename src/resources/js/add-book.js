let addBookOpen = document.getElementById("addBookOpen");
let addBookMenu = document.getElementById("addBookMenu");

let addBookClose = document.getElementById("addBookClose");

addBookOpen.addEventListener("click", function () {
    addBookMenu.style.display = "block";
});
addBookClose.addEventListener("click", function () {
    addBookMenu.style.display = "none";
});

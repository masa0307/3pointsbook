let deleteBookOpen = document.getElementById("deleteBookOpen");
let deleteBookClose = document.getElementById("deleteBookClose");
let deleteBookMenu = document.getElementById("deleteBookMenu");

deleteBookOpen.addEventListener("click", function () {
    deleteBookMenu.style.display = "block";
});
deleteBookClose.addEventListener("click", function () {
    deleteBookMenu.style.display = "none";
});

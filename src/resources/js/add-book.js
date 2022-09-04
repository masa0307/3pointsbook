let addBookOpen = document.getElementById("addBookOpen");
let addBookClose = document.getElementById("addBookClose");
addBookOpen.addEventListener("click", function () {
    document.getElementById("addBookMenu").classList = "block";
});
addBookClose.addEventListener("click", function () {
    document.getElementById("addBookMenu").classList = "hidden";
});

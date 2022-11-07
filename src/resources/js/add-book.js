if (
    window.matchMedia &&
    window.matchMedia("(max-device-width: 640px)").matches
) {
    let addBookOpenBySp = document.getElementById("addBookOpenBySp");
    let addBookMenuBySp = document.getElementById("addBookMenuBySp");

    let addBookCloseBySp = document.getElementById("addBookCloseBySp");

    addBookOpenBySp.addEventListener("click", function () {
        addBookMenuBySp.style.display = "block";
    });
    addBookCloseBySp.addEventListener("click", function () {
        addBookMenuBySp.style.display = "none";
    });
} else {
    let addBookOpen = document.getElementById("addBookOpen");
    let addBookMenu = document.getElementById("addBookMenu");
    let addBookClose = document.getElementById("addBookClose");

    addBookOpen.addEventListener("click", function () {
        addBookMenu.style.display = "block";
    });
    addBookClose.addEventListener("click", function () {
        addBookMenu.style.display = "none";
    });
}

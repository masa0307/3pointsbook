let settingScreenOpen = document.getElementById("settingScreenOpen");
let settingMenu = document.getElementById("settingMenu");

settingScreenOpen.addEventListener("click", function () {
    settingMenu.style.display = "block";
});

settingMenu.addEventListener("click", function () {
    settingMenu.style.display = "none";
});

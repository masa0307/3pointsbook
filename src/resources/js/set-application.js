let settingScreenOpen = document.getElementById("settingScreenOpen");
let settingScreenClose =
    document.getElementsByClassName("settingScreenClose")[0];
let settingMenu = document.getElementById("settingMenu");

settingScreenOpen.addEventListener("click", function () {
    settingMenu.style.display = "block";
});

settingScreenClose.addEventListener("click", function () {
    settingMenu.style.display = "none";
});

if (
    window.matchMedia &&
    window.matchMedia("(max-device-width: 640px)").matches
) {
    let settingScreenOpenBySp = document.getElementById(
        "settingScreenOpenBySp"
    );
    let settingMenuBySp = document.getElementById("settingMenuBySp");

    settingScreenOpenBySp.addEventListener("click", function () {
        settingMenuBySp.style.display = "block";
    });
    settingMenuBySp.addEventListener("click", function () {
        settingMenuBySp.style.display = "none";
    });
} else {
    let settingScreenOpen = document.getElementById("settingScreenOpen");
    let settingMenu = document.getElementById("settingMenu");

    settingScreenOpen.addEventListener("click", function () {
        settingMenu.style.display = "block";
    });

    settingMenu.addEventListener("click", function () {
        settingMenu.style.display = "none";
    });
}

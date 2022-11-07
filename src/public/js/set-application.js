/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/set-application.js ***!
  \*****************************************/
if (window.matchMedia && window.matchMedia("(max-device-width: 640px)").matches) {
  var settingScreenOpenBySp = document.getElementById("settingScreenOpenBySp");
  var settingMenuBySp = document.getElementById("settingMenuBySp");
  settingScreenOpenBySp.addEventListener("click", function () {
    settingMenuBySp.style.display = "block";
  });
  settingMenuBySp.addEventListener("click", function () {
    settingMenuBySp.style.display = "none";
  });
} else {
  var settingScreenOpen = document.getElementById("settingScreenOpen");
  var settingMenu = document.getElementById("settingMenu");
  settingScreenOpen.addEventListener("click", function () {
    settingMenu.style.display = "block";
  });
  settingMenu.addEventListener("click", function () {
    settingMenu.style.display = "none";
  });
}
/******/ })()
;
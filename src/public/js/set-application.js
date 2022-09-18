/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/set-application.js ***!
  \*****************************************/
var settingScreenOpen = document.getElementById("settingScreenOpen");
var settingScreenClose = document.getElementsByClassName("settingScreenClose")[0];
var settingMenu = document.getElementById("settingMenu");
settingScreenOpen.addEventListener("click", function () {
  settingMenu.style.display = "block";
});
settingScreenClose.addEventListener("click", function () {
  settingMenu.style.display = "none";
});
/******/ })()
;
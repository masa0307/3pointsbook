/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/add-book.js ***!
  \**********************************/
if (window.matchMedia && window.matchMedia("(max-device-width: 640px)").matches) {
  var addBookOpenBySp = document.getElementById("addBookOpenBySp");
  var addBookMenuBySp = document.getElementById("addBookMenuBySp");
  var addBookCloseBySp = document.getElementById("addBookCloseBySp");
  addBookOpenBySp.addEventListener("click", function () {
    addBookMenuBySp.style.display = "block";
  });
  addBookCloseBySp.addEventListener("click", function () {
    addBookMenuBySp.style.display = "none";
  });
} else {
  var addBookOpen = document.getElementById("addBookOpen");
  var addBookMenu = document.getElementById("addBookMenu");
  var addBookClose = document.getElementById("addBookClose");
  addBookOpen.addEventListener("click", function () {
    addBookMenu.style.display = "block";
  });
  addBookClose.addEventListener("click", function () {
    addBookMenu.style.display = "none";
  });
}
/******/ })()
;
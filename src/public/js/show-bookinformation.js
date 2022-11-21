/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/show-bookinformation.js ***!
  \**********************************************/
var topMenu = document.getElementById("topMenu");
var bookInformation = document.getElementById("bookInformation");
var showInformations = document.querySelectorAll(".showInformation");
var title = document.getElementById("title");

if (window.matchMedia && window.matchMedia("(max-device-width: 640px)").matches) {
  previous_url = document.referrer;

  if (previous_url.indexOf("search-book?") !== -1) {
    topMenu.classList.toggle("hidden");
    bookInformation.classList.toggle("hidden");
  }

  showInformations.forEach(function (showInformation) {
    showInformation.addEventListener("click", function (e) {
      if (e.target.textContent.match(title.textContent)) {
        e.preventDefault();
        topMenu.classList.toggle("hidden");
        bookInformation.classList.toggle("hidden");
      }
    });
  });
}
/******/ })()
;
/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/marker-booklist.js ***!
  \*****************************************/
var dropdowns = document.querySelectorAll(".dropdown");
var markers = document.querySelectorAll(".marker");
var title = document.getElementById("title");
dropdowns.forEach(function (dropdown) {
  if (dropdown.previousElementSibling.textContent == title.textContent) {
    dropdown.style.display = "block";
  }
});
markers.forEach(function (marker) {
  if (marker.textContent == title.textContent) {
    marker.style.backgroundColor = "#DFDFDF";
  }
});
/******/ })()
;
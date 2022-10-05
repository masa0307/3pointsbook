/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/marker-groupbooklist.js ***!
  \**********************************************/
var dropdowns = document.querySelectorAll(".groupDropdown");
var markers = document.querySelectorAll(".groupMarker");
var title = document.getElementById("title");
var groupName = document.getElementById("groupName");
dropdowns.forEach(function (dropdown) {
  if (dropdown.previousElementSibling.textContent.match(title.textContent) && dropdown.parentNode.firstElementChild.firstElementChild.textContent == groupName.textContent) {
    dropdown.style.display = "block";
  }
});
markers.forEach(function (marker) {
  if (marker.textContent.match(title.textContent) && marker.parentNode.firstElementChild.firstElementChild.textContent == groupName.textContent) {
    marker.style.backgroundColor = "#DFDFDF";
  }
});
/******/ })()
;
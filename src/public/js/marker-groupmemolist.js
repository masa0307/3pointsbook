/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/marker-groupmemolist.js ***!
  \**********************************************/
var dropdowns = document.querySelectorAll(".groupDropdown");
var markers = document.querySelectorAll(".groupMarker");
var bookMemo = document.getElementById("book-memo");
var title = document.getElementById("title");
var groupName = document.getElementById("groupName");
markers.forEach(function (marker) {
  dropdowns.forEach(function (dropdown) {
    if (dropdown.previousElementSibling.textContent.match(title.textContent) && marker.textContent == bookMemo.textContent && groupName.textContent.match(dropdown.parentNode.firstElementChild.firstElementChild.textContent)) {
      dropdown.style.display = "block";
      marker.style.backgroundColor = "#5d5a79";
      marker.style.color = "#ddd";
    }
  });
});
/******/ })()
;
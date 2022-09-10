/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/marker-memolist.js ***!
  \*****************************************/
var dropdowns = document.querySelectorAll(".dropdown");
var markers = document.querySelectorAll(".marker");
var bookMemo = document.getElementById("book-memo");
markers.forEach(function (marker) {
  if (marker.textContent == bookMemo.textContent) {
    marker.style.backgroundColor = "#DFDFDF";
  }
});
dropdowns.forEach(function (dropdown) {
  var memoID = dropdown.previousElementSibling.href.slice(-3);
  var editID = document.getElementById("edit").href.slice(-3);
  console.log(memoID);
  console.log(editID);

  if (memoID == editID) {
    console.log(true);
    dropdown.style.display = "block";
  }
});
/******/ })()
;
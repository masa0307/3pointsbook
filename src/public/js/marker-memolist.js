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
  var checkCurrentUrl = location.href.match(/edit/);
  var anchorLinkBeginIndex = dropdown.previousElementSibling.href.indexOf("show/") + 5;
  var anchorLinkEndIndex = dropdown.previousElementSibling.href.indexOf("?");
  var anchorLinkBookId = dropdown.previousElementSibling.href.slice(-3);

  if (dropdown.previousElementSibling.href.match(/\?/)) {
    anchorLinkBookId = dropdown.previousElementSibling.href.substring(anchorLinkBeginIndex, anchorLinkEndIndex);
  }

  if (checkCurrentUrl) {
    var submitLinkBookId = document.form.action.slice(-3);

    if (anchorLinkBookId == submitLinkBookId) {
      dropdown.style.display = "block";
    }
  } else {
    var editBookId = document.getElementById("edit").href.slice(-3);

    if (anchorLinkBookId == editBookId) {
      dropdown.style.display = "block";
    }
  }
});
/******/ })()
;
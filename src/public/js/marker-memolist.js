/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/marker-memolist.js ***!
  \*****************************************/
var dropdowns = document.querySelectorAll(".dropdown");
var markers = document.querySelectorAll(".marker");
var bookMemo = document.getElementById("book-memo");
markers.forEach(function (marker) {
  if (bookMemo.textContent.match(marker.textContent)) {
    marker.style.backgroundColor = "#5d5a79";
    marker.style.color = "#ddd";
  }
});
dropdowns.forEach(function (dropdown) {
  var checkCurrentUrl = location.href.match(/edit/);
  var anchorLinkBeginIndex = dropdown.previousElementSibling.href.indexOf("show/") + 5;
  var anchorLinkEndIndex = dropdown.previousElementSibling.href.indexOf("?");
  var anchorLinkBookId = dropdown.previousElementSibling.href.substring(anchorLinkBeginIndex);

  if (dropdown.previousElementSibling.href.match(/\?/)) {
    anchorLinkBookId = dropdown.previousElementSibling.href.substring(anchorLinkBeginIndex, anchorLinkEndIndex);
  }

  if (checkCurrentUrl) {
    var submitLinkBeginIndex;

    if (document.form.action.match(/store/)) {
      submitLinkBeginIndex = document.form.action.indexOf("book_id=") + 8;
    } else if (document.form.action.match(/update/)) {
      submitLinkBeginIndex = document.form.action.indexOf("update/") + 7;
    }

    var submitLinkBookId = document.form.action.substring(submitLinkBeginIndex);

    if (anchorLinkBookId == submitLinkBookId) {
      dropdown.style.display = "block";
    }
  } else {
    var editLinkBeginIndex = document.getElementById("edit").href.indexOf("edit/") + 5;
    var editLinkEndIndex = document.getElementById("edit").href.indexOf("?");
    var editBookId;

    if (editLinkEndIndex != -1) {
      editBookId = document.getElementById("edit").href.substring(editLinkBeginIndex, editLinkEndIndex);
    } else {
      editBookId = document.getElementById("edit").href.substring(editLinkBeginIndex);
    }

    if (anchorLinkBookId == editBookId) {
      dropdown.style.display = "block";
    }
  }
});
/******/ })()
;
/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/display-booklist.js ***!
  \******************************************/
var dropdowns = document.querySelectorAll(".dropdown");
var markers = document.querySelectorAll(".marker");
dropdowns.forEach(function (dropdown) {
  dropdown.addEventListener("click", function (e) {
    var dropdowned = document.getElementById("dropdowned");

    if (dropdowned) {
      dropdowned.style.display = "none";
      dropdowned.removeAttribute("id");
    }

    e.target.nextElementSibling.id = "dropdowned";
    e.target.nextElementSibling.style.display = "block";
  });
});
markers.forEach(function (marker) {
  marker.addEventListener("click", function (e) {
    var marked = document.getElementById("marked");

    if (marked) {
      marked.style.backgroundColor = "#C7EDBA";
      marked.removeAttribute("id");
    }

    e.target.id = "marked";
    e.target.style.backgroundColor = "#DFDFDF";
  });
});
/******/ })()
;
let dropdowns = document.querySelectorAll(".dropdown");
let markers = document.querySelectorAll(".marker");
let bookMemo = document.getElementById("book-memo");

markers.forEach((marker) => {
    if (marker.textContent == bookMemo.textContent) {
        marker.style.backgroundColor = "#DFDFDF";
    }
});

dropdowns.forEach((dropdown) => {
    let checkCurrentUrl = location.href.match(/edit/);
    let anchorLinkBeginIndex =
        dropdown.previousElementSibling.href.indexOf("show/") + 5;
    let anchorLinkEndIndex = dropdown.previousElementSibling.href.indexOf("?");
    let anchorLinkBookId = dropdown.previousElementSibling.href.slice(-3);

    if (dropdown.previousElementSibling.href.match(/\?/)) {
        anchorLinkBookId = dropdown.previousElementSibling.href.substring(
            anchorLinkBeginIndex,
            anchorLinkEndIndex
        );
    }

    if (checkCurrentUrl) {
        let submitLinkBookId = document.form.action.slice(-3);
        if (anchorLinkBookId == submitLinkBookId) {
            dropdown.style.display = "block";
        }
    } else {
        let editBookId = document.getElementById("edit").href.slice(-3);
        if (anchorLinkBookId == editBookId) {
            dropdown.style.display = "block";
        }
    }
});

let dropdowns = document.querySelectorAll(".dropdown");
let markers = document.querySelectorAll(".marker");
let bookMemo = document.getElementById("book-memo");

markers.forEach((marker) => {
    if (bookMemo.textContent.match(marker.textContent)) {
        marker.style.backgroundColor = "#5d5a79";
        marker.style.color = "#ddd";
    }
});

dropdowns.forEach((dropdown) => {
    let checkCurrentUrl = location.href.match(/edit/);
    let anchorLinkBeginIndex =
        dropdown.previousElementSibling.href.indexOf("show/") + 5;
    let anchorLinkEndIndex = dropdown.previousElementSibling.href.indexOf("?");
    let anchorLinkBookId =
        dropdown.previousElementSibling.href.substring(anchorLinkBeginIndex);

    if (dropdown.previousElementSibling.href.match(/\?/)) {
        anchorLinkBookId = dropdown.previousElementSibling.href.substring(
            anchorLinkBeginIndex,
            anchorLinkEndIndex
        );
    }

    if (checkCurrentUrl) {
        let submitLinkBeginIndex;

        if (document.form.action.match(/store/)) {
            submitLinkBeginIndex = document.form.action.indexOf("book_id=") + 8;
        } else if (document.form.action.match(/update/)) {
            submitLinkBeginIndex = document.form.action.indexOf("update/") + 7;
        }

        let submitLinkBookId =
            document.form.action.substring(submitLinkBeginIndex);

        if (anchorLinkBookId == submitLinkBookId) {
            dropdown.style.display = "block";
        }
    } else {
        let editLinkBeginIndex =
            document.getElementById("edit").href.indexOf("edit/") + 5;
        let editLinkEndIndex = document
            .getElementById("edit")
            .href.indexOf("?");
        let editBookId;

        if (editLinkEndIndex != -1) {
            editBookId = document
                .getElementById("edit")
                .href.substring(editLinkBeginIndex, editLinkEndIndex);
        } else {
            editBookId = document
                .getElementById("edit")
                .href.substring(editLinkBeginIndex);
        }

        if (anchorLinkBookId == editBookId) {
            dropdown.style.display = "block";
        }
    }
});

let dropdowns = document.querySelectorAll(".groupDropdown");
let markers = document.querySelectorAll(".groupMarker");
let bookMemo = document.getElementById("book-memo");
let title = document.getElementById("title");
let groupName = document.getElementById("groupName");

markers.forEach((marker) => {
    dropdowns.forEach((dropdown) => {
        if (
            dropdown.previousElementSibling.textContent.match(
                title.textContent
            ) &&
            marker.textContent == bookMemo.textContent &&
            groupName.textContent.match(
                dropdown.parentNode.firstElementChild.firstElementChild
                    .textContent
            )
        ) {
            dropdown.style.display = "block";
            marker.style.backgroundColor = "#DFDFDF";
        }
    });
});

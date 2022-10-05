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
            dropdown.parentNode.firstElementChild.firstElementChild
                .textContent == groupName.textContent
        ) {
            dropdown.style.display = "block";
            marker.style.backgroundColor = "#DFDFDF";
        }
    });
});

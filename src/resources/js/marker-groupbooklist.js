let dropdowns = document.querySelectorAll(".groupDropdown");
let markers = document.querySelectorAll(".groupMarker");
let title = document.getElementById("title");
let groupName = document.getElementById("groupName");

dropdowns.forEach((dropdown) => {
    if (
        dropdown.previousElementSibling.textContent.match(title.textContent) &&
        groupName.textContent.match(
            dropdown.parentNode.firstElementChild.firstElementChild.textContent
        )
    ) {
        dropdown.style.display = "block";
    }
});

markers.forEach((marker) => {
    if (
        marker.textContent.match(title.textContent) &&
        groupName.textContent.match(
            marker.parentNode.firstElementChild.firstElementChild.textContent
        )
    ) {
        marker.style.backgroundColor = "#DFDFDF";
    }
});

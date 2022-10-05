let dropdowns = document.querySelectorAll(".groupDropdown");
let markers = document.querySelectorAll(".groupMarker");
let title = document.getElementById("title");
let groupName = document.getElementById("groupName");

dropdowns.forEach((dropdown) => {
    if (
        dropdown.previousElementSibling.textContent.match(title.textContent) &&
        dropdown.parentNode.firstElementChild.firstElementChild.textContent ==
            groupName.textContent
    ) {
        dropdown.style.display = "block";
    }
});

markers.forEach((marker) => {
    if (
        marker.textContent.match(title.textContent) &&
        marker.parentNode.firstElementChild.firstElementChild.textContent ==
            groupName.textContent
    ) {
        marker.style.backgroundColor = "#DFDFDF";
    }
});

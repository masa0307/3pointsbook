let dropdowns = document.querySelectorAll(".dropdown");
let markers = document.querySelectorAll(".marker");
let title = document.getElementById("title");

dropdowns.forEach((dropdown) => {
    if (dropdown.previousElementSibling.textContent == title.textContent) {
        dropdown.style.display = "block";
    }
});

markers.forEach((marker) => {
    if (marker.textContent == title.textContent) {
        marker.style.backgroundColor = "#5d5a79";
        marker.style.color = "#ddd";
    }
});

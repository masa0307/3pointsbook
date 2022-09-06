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
        marker.style.backgroundColor = "#DFDFDF";
    }
});

// markers.forEach((marker) => {
//     if (marker.textContent == document.getElementById("title").textContent) {
//         marker.setAttribute("id", "marked");
//         let marked = document.getElementById("marked");
//         if (marked) {
//             marked.style.backgroundColor = "#C7EDBA";
//             marked.removeAttribute("id");
//         }
//         marked.style.backgroundColor = "#DFDFDF";
//     }
// });

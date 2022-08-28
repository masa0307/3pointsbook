let dropdowns = document.querySelectorAll(".dropdown");
let markers = document.querySelectorAll(".marker");

dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("click", function (e) {
        let dropdowned = document.getElementById("dropdowned");
        if (dropdowned) {
            dropdowned.style.display = "none";
            dropdowned.removeAttribute("id");
        }
        e.target.nextElementSibling.id = "dropdowned";
        e.target.nextElementSibling.style.display = "block";
    });
});

markers.forEach((marker) => {
    marker.addEventListener("click", function (e) {
        let marked = document.getElementById("marked");
        if (marked) {
            marked.style.backgroundColor = "#C7EDBA";
            marked.removeAttribute("id");
        }
        e.target.id = "marked";
        e.target.style.backgroundColor = "#DFDFDF";
    });
});

let dropdowns = document.querySelectorAll(".dropdown");
let markers = document.querySelectorAll(".marker");
let bookMemo = document.getElementById("book-memo");

markers.forEach((marker) => {
    if (marker.textContent == bookMemo.textContent) {
        marker.style.backgroundColor = "#DFDFDF";
    }
});

dropdowns.forEach((dropdown) => {
    let memoID = dropdown.previousElementSibling.href.slice(-3);
    let editID = document.getElementById("edit").href.slice(-3);
    console.log(memoID);
    console.log(editID);
    if (memoID == editID) {
        console.log(true);
        dropdown.style.display = "block";
    }
});

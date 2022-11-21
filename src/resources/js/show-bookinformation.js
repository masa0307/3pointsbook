let topMenu = document.getElementById("topMenu");
let bookInformation = document.getElementById("bookInformation");
let showInformations = document.querySelectorAll(".showInformation");
let title = document.getElementById("title");

if (
    window.matchMedia &&
    window.matchMedia("(max-device-width: 640px)").matches
) {
    previous_url = document.referrer;

    if (previous_url.indexOf("search-book?") !== -1) {
        topMenu.classList.toggle("hidden");
        bookInformation.classList.toggle("hidden");
    }

    showInformations.forEach((showInformation) => {
        showInformation.addEventListener("click", function (e) {
            if (e.target.textContent.match(title.textContent)) {
                e.preventDefault();
                topMenu.classList.toggle("hidden");
                bookInformation.classList.toggle("hidden");
            }
        });
    });
}

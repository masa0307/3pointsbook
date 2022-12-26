let title = document.getElementById("title");
let resultMessage = document.getElementById("resultMessage");

if (location.pathname === "/book/search") {
    let searchButton = document.getElementById("searchButton");
    searchButton.addEventListener("click", () => {
        let titleValue = title.value;
        let searchResults = document.querySelectorAll(".searchResult");

        if (searchResults.length != 0) {
            searchResults.forEach((searchResult) => {
                searchResult.remove();
            });
        }

        searchBook(titleValue);
    });
}

let RAKUTEN_APP_ID = process.env.MIX_RAKUTEN_APP_ID;

async function searchBook(titleValue) {
    let res;

    if (
        window.matchMedia &&
        window.matchMedia("(max-device-width: 640px)").matches
    ) {
        res = await fetch(
            `https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?applicationId=${RAKUTEN_APP_ID}&title=${titleValue}&hits=4`
        );
    } else {
        res = await fetch(
            `https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?applicationId=${RAKUTEN_APP_ID}&title=${titleValue}&hits=8`
        );
    }

    let books = await res.json();
    let bookInformations = books.Items;

    if (bookInformations.length) {
        resultMessage.classList.replace("block", "hidden");

        bookInformations.forEach((bookInformation) => {
            let fragment = document.createDocumentFragment();
            let div = document.createElement("div");
            let img = document.createElement("img");
            let bookInformationDiv = document.createElement("div");
            let titleParagraph = document.createElement("p");
            let authorParagraph = document.createElement("p");

            let inputImg = document.createElement("input");
            let inputTitle = document.createElement("input");
            let inputTitleKana = document.createElement("input");
            let inputAuthor = document.createElement("input");

            div.classList.add(
                "searchResult",
                "pt-6",
                "pr-4",
                "cursor-pointer",
                "flex",
                "md:block",
                "md:w-1/4"
            );

            inputImg.classList.add("hidden");
            inputTitle.classList.add("hidden");
            inputTitleKana.classList.add("hidden");
            inputAuthor.classList.add("hidden");
            img.classList.add("mr-4");

            img.src = bookInformation.Item.mediumImageUrl;
            titleParagraph.innerHTML = bookInformation.Item.title;
            authorParagraph.innerHTML = bookInformation.Item.author;

            inputImg.setAttribute("value", bookInformation.Item.mediumImageUrl);
            inputTitle.setAttribute("value", bookInformation.Item.title);
            inputTitleKana.setAttribute(
                "value",
                bookInformation.Item.titleKana
            );
            inputAuthor.setAttribute("value", bookInformation.Item.author);

            fragment.append(img);
            bookInformationDiv.append(titleParagraph);
            bookInformationDiv.append(authorParagraph);
            fragment.append(bookInformationDiv);

            fragment.append(inputImg);
            fragment.append(inputTitle);
            fragment.append(inputTitleKana);
            fragment.append(inputAuthor);

            div.append(fragment);

            let resultWindow = document.getElementById("resultWindow");

            resultWindow.appendChild(div);
        });

        let searchResults = document.querySelectorAll(".searchResult");
        searchResults.forEach((searchResult) => {
            searchResult.addEventListener("click", (e) => {
                let bookElements = e.currentTarget.childNodes;
                let bookImageSrc = bookElements[2].value;
                let bookTitle = bookElements[3].value;
                let bookTitleKana = "※カナ情報なし";
                let bookAuthor = "※著者情報なし";

                if (bookElements[4].value) {
                    bookTitleKana = bookElements[4].value;
                }

                if (bookElements[5].value) {
                    bookAuthor = bookElements[5].value;
                }

                const postData = new FormData();
                postData.append("img", bookImageSrc);
                postData.append("title", bookTitle);
                postData.append("title_kana", bookTitleKana);
                postData.append("author", bookAuthor);

                fetch("/book/temporaryStore", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: postData,
                }).then(() => (window.location.href = "/book/create"));
            });
        });
    } else {
        resultMessage.classList.replace("hidden", "block");
    }
}

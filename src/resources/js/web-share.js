let shareButtons = document.querySelectorAll(".shareButton");

if (typeof navigator.share === "undefined") {
    shareButtons.forEach((shareButton) => {
        shareButton.classList.add("hidden");
    });
} else {
    shareButtons.forEach((shareButton) => {
        shareButton.addEventListener("click", async (e) => {
            try {
                if (location.href.match(/book-memo/)) {
                    let shareData = {
                        text: `${e.target.parentNode.parentNode.parentNode.parentNode.parentNode.firstElementChild.textContent}
                                （${e.target.parentNode.previousElementSibling.textContent}メモ）
                                ・${e.target.parentNode.parentNode.nextElementSibling.value}
                        `.replace(/^\n|\s+$|^ {28}/gm, ""),
                    };
                    await navigator.share(shareData);
                } else if (location.href.match(/action-list/)) {
                    let shareData = {
                        text: `
                            ${
                                e.target.parentNode.parentNode.parentNode
                                    .firstElementChild.textContent
                            }
                                （アクションリスト１メモ）
                                ・${
                                    document.getElementById("actionMemo1")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （アクションリスト２メモ）
                                ・${
                                    document.getElementById("actionMemo2")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （アクションリスト３メモ）
                                ・${
                                    document.getElementById("actionMemo3")
                                        .lastElementChild.textContent
                                }
                        `.replace(/^\n|\s+$|^ {28}/gm, ""),
                    };
                    await navigator.share(shareData);
                } else if (location.href.match(/feedback-list/)) {
                    let shareData = {
                        text: `
                            ${
                                e.target.parentNode.parentNode.parentNode
                                    .firstElementChild.textContent
                            }
                                （フィードバック１メモ）
                                ・${
                                    document.getElementById("feedbackMemo1")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （フィードバック２メモ）
                                ・${
                                    document.getElementById("feedbackMemo2")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （フィードバック３メモ）
                                ・${
                                    document.getElementById("feedbackMemo3")
                                        .lastElementChild.textContent
                                }
                        `.replace(/^\n|\s+$|^ {28}/gm, ""),
                    };
                    await navigator.share(shareData);
                }
            } catch (e) {
                throw new Error(e);
            }
        });
    });
}

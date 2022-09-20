let shareButtons = document.querySelectorAll(".shareButton");
console.log();

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
                        text: `
                            【${e.target.parentNode.parentNode.firstElementChild.textContent}】
                                （${e.target.previousElementSibling.previousElementSibling.textContent}メモ）
                                ・${e.target.nextElementSibling.value}
                        `.replace(/^\n|\s+$|^ {28}/gm, ""),
                    };
                    await navigator.share(shareData);
                } else if (location.href.match(/action-list/)) {
                    let shareData = {
                        text: `
                            【${
                                e.target.parentNode.parentNode.firstElementChild
                                    .textContent
                            }】
                                （アクションリスト1メモ）
                                ・${
                                    document.getElementById("actionMemo1")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （アクションリスト2メモ）
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
                            【${
                                e.target.parentNode.parentNode.firstElementChild
                                    .textContent
                            }】
                                （フィードバック1メモ）
                                ・${
                                    document.getElementById("feedbackMemo1")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （フィードバック2メモ）
                                ・${
                                    document.getElementById("feedbackMemo2")
                                        .firstElementChild.nextElementSibling
                                        .textContent
                                }
                                （フィードバック3メモ）
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

$(function () {
    // 投稿の画像プレビュー
    if ($(".postImg-input_container").length) {
        var postImgInputItem = `<li class="postImg-input_item col-md-3 col-6">
                        <div class="postImg_preview_unit d-none">
                            <button class="postImg_delete"><i class="fa-solid fa-xmark"></i></button>
                            <img src="" alt="画像プレビュー" class="postImg_preview mb-2">
                        </div>
                        <label class="btn">
                            <i class="fas fa-image"></i>
                            <p class="mb-0">追加</p>
                            <input type="file" name="postImgs[]" accept=".png, .jpg, .jpeg" class="postImgInput" value="" hidden>
                        </label>
                    </li>`;
        $(document).on("change", 'input[type="file"]', function () {
            var changedInput = $(this);
            var cahngedPostInputItem = changedInput.parent().parent();
            var postImg_preview_unit = changedInput
                .parent()
                .siblings(".postImg_preview_unit");
            var currentImg_preview_unit = changedInput
                .parent()
                .siblings(".currentImg_preview_unit");
            var inputLength = $(".postImg-input_item").length;
            var currentImgId = currentImg_preview_unit
                .children("img")
                .attr("id");
            var cahngedInputIndex = cahngedPostInputItem.index(
                ".postImg-input_container li"
            );
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                postImg_preview_unit
                    .children("img")
                    .attr("src", e.target.result);
            };
            if (this.files[0]) {
                fileReader.readAsDataURL(this.files[0]);
                postImg_preview_unit.removeClass("d-none");
                currentImg_preview_unit.addClass("d-none");
                console.log(currentImg_preview_unit.length);
                if (currentImg_preview_unit.length == 1) {
                    var exchanges =
                        `<input type="hidden" name="exchanges[]" value="` +
                        cahngedInputIndex +
                        `/` +
                        currentImgId +
                        `">`;
                    cahngedPostInputItem.append(exchanges);
                }
                if (
                    changedInput.prev("p").text() == "追加" &&
                    inputLength < 4
                ) {
                    $(".postImg-input_container").append(postImgInputItem);
                }
                changedInput.prev("p").text("変更");
            } else {
                if (currentImg_preview_unit.length == 1) {
                    postImg_preview_unit.addClass("d-none");
                    currentImg_preview_unit.removeClass("d-none");
                    cahngedPostInputItem
                        .children('input[name="exchanges[]"]')
                        .remove();
                    postImg_preview_unit.children("img").attr("src", "");
                } else {
                    let tuikaBtnLength = $(
                        ".postImg-input_container li label"
                    ).children("p:contains('追加')").length;
                    if (tuikaBtnLength == 0) {
                        $(".postImg-input_container").append(postImgInputItem);
                    }
                    cahngedPostInputItem.remove();
                }
            }
        });
        $(document).on("click", ".postImg_delete", function () {
            let tuikaBtnLength = $(
                ".postImg-input_container li label"
            ).children("p:contains('追加')").length;
            $(this).parent().parent().remove();
            if (tuikaBtnLength == 0) {
                $(".postImg-input_container").append(postImgInputItem);
            }
            if ($(this).parent().parent().find(".currentImg_preview").length) {
                let deleteImgId = $(this)
                    .parent()
                    .parent()
                    .find(".currentImg_preview")
                    .attr("id");
                var inputDelete = $('input[name="deleteImg"]');
                var deleteImgValue = inputDelete.attr("value");
                if (deleteImgValue == "none") {
                    inputDelete.attr("value", deleteImgId);
                } else {
                    inputDelete.attr(
                        "value",
                        deleteImgValue + `/` + deleteImgId
                    );
                }
            }
        });
    }

    // トップページのタブ切り替え
    function showCategorySwitch(param_name) {
        const btn = $("." + param_name + "_btn");
        const container = $("." + param_name + "_container");
        $(".category_btn").removeClass("active");
        $(".category_container").removeClass("active");
        $(btn).addClass("active");
        $(container).addClass("active");
        $('input[name="activeList"]').val(param_name);
    }
    $(document).ready(function () {
        var param_name = "posts";
        var locationSearch = $(location).attr("search");
        if (locationSearch) {
            var exit = locationSearch.indexOf("activeList=users");
            if (exit !== -1) {
                var param_name = "users";
            }
        }
        showCategorySwitch(param_name);
    });
    $(".category_btn").click(function () {
        var param_name = $(this).attr("id");
        showCategorySwitch(param_name);
    });

    // ユーザー詳細ページのタイムライン内のタブ切り替え
    $(".timeline-category")
        .children(".btn")
        .click(function () {
            $(".timeline-category").children(".btn").removeClass("active");
        });
    $(".timeline-posts").click(function () {
        $(".posts-list").show();
        $(".timeline-list").hide();
        $(this).addClass("active");
    });
    $(".timeline-timeline").click(function () {
        $(".timeline-list").show();
        $(".posts-list").hide();
        $(this).addClass("active");
    });

    //　ユーザーアイコン変更時のプレビュー
    if ($("#iconModalBtn").length) {
        $("#iconModalBtn").click(function () {
            $('input[name="icon"]').trigger("click");
        });

        function getIconSrc() {
            src = document
                .querySelector("#user_icon_preview .user_icon")
                .getAttribute("src");
            return src;
        }
        const currentIconSrc = getIconSrc();
        document.querySelector('input[name="icon"]').onchange = function () {
            let fileReader = new FileReader();
            fileReader.onload = function (e) {
                document
                    .querySelector("#user_icon_preview .user_icon")
                    .setAttribute("src", e.target.result);
            };
            if (this.files[0]) {
                fileReader.readAsDataURL(this.files[0]);
                let fileSize = this.files[0].size;
                if (fileSize >= 1024 * 1024) {
                    $(".fileSize-text").text(
                        "画像サイズが大きすぎます。画像サイズは1MBまでです。"
                    );
                    $(".saveIcon-btn").prop("disabled", true);
                } else {
                    $(".fileSize-text").text("");
                    $(".saveIcon-btn").prop("disabled", false);
                }
            } else {
                document
                    .querySelector("#user_icon_preview .user_icon")
                    .setAttribute("src", currentIconSrc);
                $(".saveIcon-btn").prop("disabled", true);
            }
        };
    }
});

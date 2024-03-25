$(function () {
    // 投稿の画像プレビュー
    if ($(".postImg-input_container").length) {
        var postImgInputItem = `<li class="postImg-input_item col-md-3 col-6">
                                    <img src="" alt="画像プレビュー" class="postImg_preview mb-2">
                                    <label class="btn">
                                        <i class="fas fa-image"></i>
                                        <p class="mb-0">追加</p>
                                        <input type="file" name="postImgs[]" accept=".png, .jpg, .jpeg" class="postImgInput"
                                        hidden>
                                    </label>
                            </li>`;
        var postImg_delete = `<button class="postImg_delete"><i class="fa-solid fa-xmark"></i></button>`;
        $(document).on("change", 'input[type="file"]', function () {
            var changedInput = $(this);
            var postImg_preview = changedInput
                .parent()
                .prev(".postImg_preview");
            var previewLength = $(".postImg-input_item").length;
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                postImg_preview.attr("src", e.target.result);
            };
            if (this.files[0]) {
                fileReader.readAsDataURL(this.files[0]);
                postImg_preview.addClass("d-block");
                $(this).parent().parent().append(postImg_delete);
                if (
                    changedInput.prev("p").text() == "追加" &&
                    previewLength < 4
                ) {
                    $(".postImg-input_container").append(postImgInputItem);
                }
                changedInput.prev("p").text("変更");
            }
        });
        $(document).on("click", ".postImg_delete", function () {
            let previewLength = $(".postImg_delete").length;
            $(this).parent().remove();
            if (previewLength == 4) {
                $(".postImg-input_container").append(postImgInputItem);
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

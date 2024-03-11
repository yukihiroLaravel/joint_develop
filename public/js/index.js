$(function () {
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

    //　ユーザーアイコン変更時のプレビュー
    window.onload = function () {
        let currentIconSrc = document
            .querySelector("#user_icon_preview")
            .getAttribute("src");
        return currentIconSrc;
    };
    document.querySelector('input[name="icon"]').onchange = function () {
        if (condition) {
        }
        let fileReader = new FileReader();
        fileReader.onload = function (e) {
            document
                .querySelector("#user_icon_preview")
                .setAttribute("src", e.target.result);
        };
        fileReader.readAsDataURL(this.files[0]);
    };
});

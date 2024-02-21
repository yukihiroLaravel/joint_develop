$(function () {
    $(".search_btn").on("click", function () {
        $(this).parent("nav").next(".search_form").toggleClass("active");
    });
});

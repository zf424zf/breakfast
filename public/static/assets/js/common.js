$(function () {
    $(".swiper-container").swiper({
            autoplay: 5000,
            loop: true
        }
    );
    $(document).on('click','.location-list p',function () {
        $(".location-list p").removeClass("active");
        $(this).addClass("active");
        $(".location-list p").siblings("dl").css("display", "none");
        $(this).siblings("dl").css("display", "block");
    })
});
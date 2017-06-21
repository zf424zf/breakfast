$(function () {

    $(document).on('click', '.location-list p', function () {
        $(".location-list p").removeClass("active");
        $(this).addClass("active");
        $(".location-list p").siblings("dl").css("display", "none");
        $(this).siblings("dl").css("display", "block");
    });

    $(document).on("pageInit", "#index", function (e, id, page) {
        $(".swiper-container").swiper({
                autoplay: 3000,
                loop: true
            }
        );
    });
    $(document).on('click', '.map-box .detail', function () {
        if ($(this).closest('li').hasClass('current')) {
            $('.map').hide();
            $('.map-box li').removeClass('current');
        } else {
            $('.map').hide();
            $('#map-' + $(this).data('id')).show();
            $('.map-box li').removeClass('current');
            $(this).closest('li').addClass('current');
        }

    })
    $(document).on('change', '#station-select', function () {
        var query = $(this).data('metro') ? '?metro_id=' + $(this).data('metro') : '';
        $.router.load('/station/' + $(this).val() + query, true)
    })
    $(document).on("pageInit", "#choose-place", function (e, id, page) {
        $('.map').each(function () {
            var center = new qq.maps.LatLng($(this).data('lat'), $(this).data('lng'));
            var container = document.getElementById($(this).attr('id'));
            var map = new qq.maps.Map(container, {
                center: center,
                zoom: 20
            });
            var marker = new qq.maps.Marker({
                position: center,
                draggable: true,
                map: map
            });
        })
        //$('.map-box li').eq(0).trigger('click');
    });

    /*早餐详情*/
    $(".food-alert").on("click", function () {
        $(".cover").css("display", "block");
        $(".food-detail").css("display", "block");
    });
    $(".close-btn").on("click", function () {
        $(".cover").css("display", "none");
        $(".food-detail").css("display", "none");
    });
    /*订餐购物车*/
    $(".cart-box").on("click", function () {
        $(".cover").css("display", "block");
        $(".food-list").css("display", "block");
    });
    $(".cover").on("click", function () {
        $(".cover").css("display", "none");
        $(".food-list").css("display", "none");
    })
    $.init();
});
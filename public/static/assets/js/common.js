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
    });
    $(document).on('click','.map-box li',function () {
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');

        var center = new qq.maps.LatLng(lat, lng);

        var container = document.getElementById("place-map");
        var map = new qq.maps.Map(container, {
            center: center,
            zoom: 17
        });

        var marker = new qq.maps.Marker({
            position: center,
            draggable: true,
            map: map
        });
    })
    $(document).on("pageInit", "#choose-station", function(e, id, page) {

    });

    /*早餐详情*/
    $(".food-alert").on("click",function(){
        $(".cover").css("display","block");
        $(".food-detail").css("display","block");
    });
    $(".close-btn").on("click",function(){
        $(".cover").css("display","none");
        $(".food-detail").css("display","none");
    });
    /*订餐购物车*/
    $(".cart-box").on("click",function(){
        $(".cover").css("display","block");
        $(".food-list").css("display","block");
    });
    $(".cover").on("click",function(){
        $(".cover").css("display","none");
        $(".food-list").css("display","none");
    })
    $.init();
});
$(function () {
    //全局监听事件
    $(document).on("pageInit", ".page", function (e, id, page) {
        $.ajaxSettings.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
    });
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
    //购物车
    var computeCartList = function () {
        $('#cart-list li').each(function () {
            var count = parseInt($(this).attr('data-count'));
            $(this).find('.food-count').html(count);
            if (count) {
                $(this).find('.food-count,.food-reduce').show();
            } else {
                $(this).find('.food-count,.food-reduce').hide();
            }
        })
        $.ajax({
            url: '/cart/list',
            type: 'GET',
            dataType: 'json',
            cache: false,
            success: function (json) {
                if (json.count) {
                    $('#cart-count').html(json.count).show();
                } else {
                    $('#cart-count').hide();
                }
                $('#food-list').html(json.html);
            }
        });
    }
    $(document).on("pageInit", "#cart", function (e, id, page) {
        computeCartList();
    });
    $(document).on('click', '.food-reduce,.food-add', function () {
        var count = parseInt($(this).closest('li').attr('data-count'));
        if ($(this).hasClass('food-add')) {
            count++;
        } else {
            count--;
        }
        var productId = $(this).closest('li').data('id');
        var date = $(this).closest('li').data('date');
        var data = {
            'product_id': productId,
            'date': date,
            'count': count
        };
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            async: false,
            success: function (json) {
            }
        });
        $('li[data-date="' + date + '"][data-id="' + productId + '"]').attr('data-count', count).find('.food-count').html(count);
        computeCartList();
    })
    //购物车结束
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
    $(".close-btn,.cover").on("click", function () {
        $(".cover").css("display", "none");
        $(".food-detail").css("display", "none");
    });
    /*订餐购物车*/
    $(document).on('click', '.cart-box', function () {
        $(".cover").css("display", "block");
        $("#food-list").css("display", "block");
    })
    $(document).on('click', '.cover', function () {
        $(".cover").css("display", "none");
        $("#food-list").css("display", "none");
    })
    $.init();
});

/**
 * 替换缩略图
 * @param imgurl 图片链接
 * @param w  宽度
 * @param h  高度
 */
window.thumb = function (imgurl, w, h) {
    var suffix = [];
    if (w && parseInt(w)) {
        suffix.unshift('w_' + w);
    }
    if (h && parseInt(h)) {
        suffix.unshift('h_' + h);
    }
    if (suffix.length > 0) {
        suffix.unshift('Q_100');
        suffix.unshift('m_fill');
        suffix.unshift('x-oss-process=image/resize');
    }
    return imgurl + '?' + suffix.join(',');

}

window.isMobilePhone = function (phone) {
    if (phone.match(/^((1[34578]{1})+\d{9})$/)) {
        return true;
    } else {
        return false;
    }
};

window.isEmail = function (email) {
    if (email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/)) {
        return true;
    } else {
        return false;
    }
}
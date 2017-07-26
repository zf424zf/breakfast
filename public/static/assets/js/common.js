$(function () {
    //全局监听事件
    $(document).on("pageInit", ".page", function (e, id, page) {
        $.ajaxSettings.headers = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
        //
        if ($('#' + id).data('config')) {
            wx.config(JSON.parse($('#' + id).data('config')));
        }

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
            $(this).closest('li').find('.icon').removeClass('icon-up').addClass('icon-down');
        } else {
            $('.map').hide();
            $('#map-' + $(this).data('id')).show();
            $('.map-box li').removeClass('current');
            $(this).closest('li').addClass('current');
            $(this).closest('li').find('.icon').removeClass('icon-down').addClass('icon-up');
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
            async: false,
            success: function (json) {
                if (json.count) {
                    $('#cart-count').html(json.count).show();
                    $('#choose-ok').removeClass('disabled').prop('href', $('#choose-ok').data('href'));
                } else {
                    $('#cart-count').hide();
                    $('#choose-ok').addClass('disabled').prop('href', 'javascript:;');
                }
                $('#food-list').html(json.html);
                $('#amount').html(json.amount)
                if (json.coupon_amount) {
                    $('#coupon-amount').html(json.coupon_amount).closest('span').show();
                } else {
                    $('#coupon-amount').html(0).closest('span').hide();
                }

            }
        });
    }
    $(document).on("pageInit", "#cart", function (e, id, page) {
        computeCartList();
    });
    $(document).on('click', '.food-reduce,.food-add', function () {
        var count = parseInt($(this).closest('li').attr('data-count'));
        var isAdd;
        if ($(this).hasClass('food-add')) {
            count++;
            isAdd = true;
        } else {
            count--;
            isAdd = false;
        }
        var productId = $(this).closest('li').data('id');
        var date = $(this).closest('li').data('date');
        var placeId = $(this).closest('li').data('place');
        var pickuptimeId = $(this).closest('li').data('pickuptime');
        var data = {
            'product_id': productId,
            'date': date,
            'count': count,
            'pickuptime_id': pickuptimeId,
            'place_id': placeId,
            'is_add': isAdd
        };
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: data,
            dataType: 'json',
            cache: false,
            async: false,
            success: function (json) {
                if (json.error) {
                    $.toast(json.message)
                } else {
                    $('li[data-date="' + date + '"][data-pickuptime="' + pickuptimeId + '"][data-place="' + placeId + '"][data-id="' + productId + '"]').attr('data-count', count).find('.food-count').html(count);
                    computeCartList();
                }
            }
        });

    })
    $(document).on('click', '#calendar a', function (e) {
        $.fn.cookie('date', $(this).data('date'), {path: '/', expires: 3});
        window.location.reload();
    })
    $(document).on('change', '#pickuptime', function (e) {
        $.fn.cookie('pickuptime', $(this).val(), {path: '/', expires: 3});
        window.location.reload();
    })
    /*早餐详情*/
    $(document).on('click', '.food-alert', function () {
        $('#food-detail').load('/product/' + $(this).closest('li').data('id'), function () {
            $(".cover").css("display", "block");
            $(".food-detail").css("display", "block");
        })
    })
    $(document).on('click', '.close-btn,.cover', function () {
        $(".cover").css("display", "none");
        $(".food-detail").css("display", "none");
    })
    //添加购物车
    $(document).on('click', '#add-to-cart', function (e) {
        $('#cart-list li[data-id="' + $(this).attr('data-id') + '"] .food-add').click();
        $('.close-btn').click();
    })
    /*订餐购物车*/
    $(document).on('click', '.cart-box', function () {
        $(".cover").css("display", "block");
        $("#food-list").css("display", "block");
    })
    $(document).on('click', '.cover', function () {
        $(".cover").css("display", "none");
        $("#food-list").css("display", "none");
    })
    //购物车结束
    $(document).on('change', '#station-select', function () {
        var query = $(this).data('metro') ? '?metro_id=' + $(this).data('metro') : '';
        $.router.load('/station/' + $(this).val() + query, true)
    })
    var payOrder = function () {
        $(document).one('click', '#confirm-pay', function () {
            $.ajax({
                url: '/order/pay',
                type: 'POST',
                data: {order_ids: $(this).data('orders')},
                dataType: 'json',
                cache: false,
                async: false,
                success: function (json) {
                    payOrder();
                    if (json.error) {
                        $.toast(json.message);
                    }
                    else {
                        //订单金额为0的时候不需要支付
                        if (json.need_pay) {
                            wx.chooseWXPay({
                                timestamp: json.config.timestamp,
                                nonceStr: json.config.nonceStr,
                                package: json.config.package,
                                signType: json.config.signType,
                                paySign: json.config.paySign,
                                success: function (res) {
                                    $.router.load('/order/result');
                                }
                            })
                        } else {
                            $.router.load('/order/result');
                        }
                    }
                },
                error: function () {
                    payOrder();
                }
            });
        })
    }
    payOrder();
    var createOrder = function () {
        $(document).one('click', '#create-order', function () {
            var data = {
                name: $('input[name="name"]').val(),
                phone: $('input[name="phone"]').val(),
                company: $('input[name="company"]').val()
            };
            $.ajax({
                url: '/order/create',
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                async: false,
                success: function (json) {
                    createOrder();
                    if (json.error) {
                        $.toast(json.message);
                    }
                    else {
                        $.router.load('/order/pay?order_ids=' + json.order_ids.join(','), true);
                    }
                },
                error: function () {
                    createOrder();
                }
            });
        })
    }
    createOrder();
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
    $(document).on('click', '.cancel-order', function () {
        var orderIds = $(this).data('ids');
        $.confirm('确定取消此订单?', function () {
            $.ajax({
                url: '/order/cancel',
                type: 'POST',
                data: {order_ids: orderIds},
                dataType: 'json',
                cache: false,
                success: function (json) {
                    if (json.error) {
                        $.alert(json.message)
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

    })
    $(document).on('click', '#confirm-pickup', function () {
        var orderId = $(this).data('id');
        $.confirm('确定已取货?', function () {
            $.ajax({
                url: '/order/pickup',
                type: 'POST',
                data: {order_id: orderId},
                dataType: 'json',
                cache: false,
                success: function (json) {
                    if (json.error) {
                        $.alert(json.message)
                    } else {
                        $.router.load('/order/pickuped?order_id=' + orderId, true);
                    }
                }
            });
        });

    })
    $(document).on('click', '.order-refund', function () {
        var orderId = $(this).data('id');
        $.confirm('确定要申请退款吗?', function () {
            $.ajax({
                url: '/order/refund',
                type: 'POST',
                data: {order_id: orderId},
                dataType: 'json',
                cache: false,
                success: function (json) {
                    if (json.error) {
                        $.alert(json.message)
                    } else {
                        window.location.reload()
                    }
                }
            });
        });

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
$(document).ready(function () {
    $(".order_info").validate({
        rules: {
            name: {required: true},
            address: {required: true},
            phone: {required: true, number: true, minlength: 9, maxlength: 11},
            city: {required: true},
            district: {required: true},
            email: {email: true},
        }, messages: {
            name: {
                required: 'Họ tên không được bỏ trống'
            },
            phone: {
                required: 'Số điện thoại không được bỏ trống',
                number: 'Số điện thoại không hợp lệ',
                minlength: 'Số điện thoại không hợp lệ',
                maxlength: 'Số điện thoại không hợp lệ',
            },
            address: {
                required: 'Địa chỉ nhận hàng không được bỏ trống'
            },
            city: {
                required: 'Hãy chọn tỉnh thành'
            },
            district: {
                required: 'Vui lòng chọn quận huyện'
            },
            email: {
                email: 'Email không hợp lệ'
            }
        }
    });


    $('input[name="submit"]').click(function () {
        if ($('.order_info').valid()) {
            var check_phone = false;
            var phone = $('input[name="phone"]').val();
            if (phone.charAt(0) == 0) {
                if (phone.indexOf('.') == -1) {
                    if (phone.charAt(1) == 9 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 1 && phone.length == 11) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 1 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 2 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 3 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 4 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 5 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 6 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 7 && phone.length == 10) {
                        check_phone = true;
                    }
                    if (phone.charAt(1) == 8 && phone.length == 10) {
                        check_phone = true;
                    }
                }
            }
            if (!check_phone) {
                alert('Số điện thoại không hợp lệ !');
                return false;
            }
        }

    });
    $(".ddl_quan").change(function () {
        $('.form_loading').show();
        var sku_id = $(this).attr('sku_id');
        var quantity = $(this).val();
        $.post('/order/change_quantity', {sku_id: sku_id, quantity: quantity}, function (result) {
            if (result == 1) {
                location.reload();
            } else {
                $('.form_loading').fadeOut();
                alert(result);

            }
        });
    });
    $('span.del').click(function () {
        var sku_id = $(this).attr('sku_id');
        $.post('/order/del_product', {sku_id: sku_id}, function (result) {
            location.reload();
        });
    });
    get_shipping_price();
    $("input[name='voucher']").blur(function () {
        var val = $(this).val();
        $('.voucher_error').html('');
        $('.voucher_success').html('');
        $('.discount_price').attr('rel', 0);
        $('.discount_price').html(formatDollar(0));
        if (val) {
            $.post('/order/check_voucher', {voucher: val}, function (result) {
                result = JSON.parse(result);
                if (result.error == 1) {
                    $('.voucher_error').html('Voucher không hợp lệ');
                } else {
                    var discount_price = parseInt(result.price);
                    if (result.type == '%') {
                        var total = parseInt($('.grand_total_money').attr('rel'));
                        discount_price = discount_price * total / 100;
                    }
                    $('.voucher_success').html('Giãm ' + result.price + result.type + ' cho tổng giá trị hoá đơn');
                    $('.discount_price').attr('rel', discount_price);
                    $('.discount_price').html(formatDollar(discount_price));
                    $('.voucher_info').show();
                    calc_price();
                }
            });
        }
    });
});
function get_shipping_price() {
    var city_id = $('#rq_province').val();
    var district_id = $('#rq_district').val();
    var result = 0;
    if (city_id && district_id) {
        $.ajax({
            url: '/order/get_shipping_price/' + city_id + '/' + district_id,
            data: "",
            type: "POST",
            async: false,
            success: function (data) {
                result = parseInt(data);
            }
        });

    }
    $('.shipping_price').attr('rel', result);
    $('.shipping_price').html(formatDollar(result));
    calc_price();
}
function calc_price() {
    var shipping_price = parseInt($('.shipping_price').attr('rel'));
    var total = parseInt($('.grand_total_money').attr('rel'));
    var discount_price = parseInt($('.discount_price').attr('rel'));
    $(".total_money").html(formatDollar(shipping_price + total - discount_price));
}
function formatDollar(num) {
    var p = num + '';
    return  p.split("").reverse().reduce(function (acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "");
}

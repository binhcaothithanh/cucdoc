$('#rq_province').change(function () {
    select_location(this, '#rq_district', '<option value="">-Chọn Quận/huyện-</option>');
});
$('#rq_district').change(function () {
    if (typeof get_shipping_price != "undefined")
        get_shipping_price();
});
function select_location(_this, selecter, html) {
    var val = $(_this).val();
    if (val) {
        $.post('/order/select_location', {id: val}, function (data) {
            if (data) {
                data = JSON.parse(data);
                $.each(data, function (k, v) {
                    html += '<option value="' + v['id'] + '">' + v['name'] + '</option>';
                });
                $(selecter).html(html);
                if ($(_this).attr('id') == 'rq_province') {
                    $('#rq_ward').html('<option value="">Phường/Xã</option>');
                }
            }
            $('.summary-setup-order-box .form_loading').hide();
            if (typeof get_shipping_price != "undefined")
                get_shipping_price();
        });
    } else {
        if ($(_this).attr('id') == 'rq_province') {
            $('#rq_district').html('<option value="">-Chọn Quận/huyện-</option>');
        }
        $('#rq_ward').html('<option value="">Phường/Xã</option>');
        if (typeof get_shipping_price != "undefined")
            get_shipping_price();
    }
}
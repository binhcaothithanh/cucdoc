$('#rq_province').change(function () {
    select_location(this, '#rq_district', '');
});

function select_location(_this, selecter, html) {
    var val = $(_this).val();
    if (val) {
        $.post('/' + admin_url + '/order/select_location', {id: val}, function (data) {
            if (data) {
                data = JSON.parse(data);
                $.each(data, function (k, v) {
                    html += '<option value="' + v['name'] + '">' + v['name'] + '</option>';
                });
                $(selecter).html(html);
               
            }
                  
        });
    } 
}
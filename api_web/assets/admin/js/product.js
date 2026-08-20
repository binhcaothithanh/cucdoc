String.prototype.replaceAll = function (target, replacement) {
    return this.split(target).join(replacement);
};
var editor2 = CKEDITOR.replace('content');
CKFinder.setupCKEditor(editor2, '/assets/admin/ckfinder/');
var reader = new FileReader(),
        i = 0,
        numFiles = 0,
        imageFiles;
function readFile() {
    reader.readAsDataURL(imageFiles[i])
}
reader.onloadend = function (e) {
    var image = "<div class='row'><img src ='" + e.target.result + "'/></div>";
    $(image).appendTo('#image');
    if (i < numFiles) {
        i++;
        readFile();
    }
};
$('#images').change(function () {
    imageFiles = document.getElementById('images').files
    $('#image').html('');
    i = 0;
    numFiles = imageFiles.length;
    readFile();
});
$("#add_attr").click(function () {
    var attr_color = [];
    $('.attr_color').each(function () {
        if ($(this).is(':checked'))
            attr_color.push($(this).val());
    });
    if ($.isEmptyObject(attr_color)) {
        alert('Vui lòng chọn màu sắc');
    } else {
        var attr_size = [];
        $('.attr_size').each(function () {
            if ($(this).is(':checked'))
                attr_size.push($(this).val());
        });
        if ($.isEmptyObject(attr_size))
            attr_size.push('');
        $.each(attr_color, function (k, v) {
            $.each(attr_size, function (k1, v1) {
                var attr = v + '|' + v1;
                if ($('.table_attr tbody tr[rel="' + attr + '"]').length == 0) {
                    var html = '<tr color="' + v + '" rel="' + attr + '">' + '<td>' + v1 +
                            '<input type="hidden" name="attr_color[]" value="' + v + '"/><input type="hidden" name="attr_size[]" value="' + v1 + '"/> <input class="count format_number" value="5" name="count[]"/></td>' +
                            '<td><a class="del_attr" href="javscript:void(0)">Xoá</a></td></tr>';
                    if ($('.table_attr tbody tr[color="' + v + '"]').length == 0) {
                        html = '<tr color="' + v + '"><td rowspan="2" color="' + v + '">' + v + '</td><td colspan="2"><input type="file" name="' + (v.replaceAll(' ', '_')) + '"/></td></tr>' + html;
                        $('.table_attr tbody').append(html);
                    } else {
                        $('.table_attr tbody tr td[color="' + v + '"]').attr('rowspan', function (i, old) {
                            return +old + 1
                        });
                        $('.table_attr tbody tr:nth-child(' + get_last_color(v) + ')').after(html);
                    }

                }
            });
        });
        $('.add_attr_success').show();
        $('.format_number').autoNumeric('init', {aPad: false});
        setTimeout(function () {
            $('.add_attr_success').fadeOut();
        }, 2000);
    }

    return false;
});
$(".table_attr").on('click', '.del_attr', function () {

    var parent = $(this).parents('tr');
    var id = $(parent).attr('id') | 0;
    if (id) {
        $(".loading_content").show();
        $.ajax({
            url: admin_url + "del_attr",
            data: "id=" + id,
            type: "POST",
            async: false
        });
        $(".loading_content").hide();
    }
    var color = $(parent).attr('color');
    if ($('.table_attr tbody tr[color="' + color + '"]').length < 3) {
        $('.table_attr tbody tr[color="' + color + '"]').remove();
    } else {
        $('.table_attr tbody tr td[color="' + color + '"]').attr('rowspan', function (i, old) {
            return +old - 1
        });
        $(parent).remove();
    }
});
function get_last_color(color) {
    var index = 0;
    $('.table_attr tbody tr').each(function (key) {
        if ($(this).attr('color') == color)
            index = key;
    });
    return index + 1;
}
$("#form").validate({
    rules: {
        title: {required: true},
        cat_id: {required: true},
        price: {required: true},
        cogs: {required: true}
    },
    messages: {
        'title': 'Vui lòng nhập tên sản phẩm',
        'cat_id': 'Vui lòng chọn loại sản phẩm',
        'price': 'Vui lòng nhập giá bán',
        'cogs': 'Vui lòng nhập giá vốn',
    }
});
//$('select[name="cat_id"]').change(function () {
//    var val = $(this).val();
//    if (val) {
//        var rel = $('option:selected', this).attr('rel').split(',');
//        $('.attr_filter').hide();
//        $.each(rel, function (k, v) {
//            $('div[rel="' + v + '"]').show();
//        });
//    } else {
//        $('.attr_filter').show();
//    }
//});
$('.format_number').autoNumeric('init', {aPad: false});

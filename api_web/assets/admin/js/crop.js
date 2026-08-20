var _Jcrop = '';
var file = null;
var current_parent = '';
var current_width, current_height;
$(document).on('click', '.but_crop', function() {
    var parent = $(this).parent();
    if ($('.img_crop', parent).attr('src') == '') {
        alert('Vui Lòng chọn hình để crop');
    } else {
        $('.dialog_crop', parent).show();
//        $('body').animate({scrollTop: 0}, '3000', 'swing', function() {
//        });
//        if (_Jcrop != '') {
//            _Jcrop.destroy();
//            
//        }      
        current_parent = parent;
        _Jcrop = $.Jcrop($('.img_crop', parent), {
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: current_width / current_height
        });
    }
    return false;
});
$(document).on('click', '.mask', function() {
    $(this).parent().hide();
})
$(document).on('click', '.crop_save', function() {
    $(this).parents('.dialog_crop').hide();
})

function getSize(obj) {
    var img = new Image();
    img.src = obj.attr('src');
    var originalWidth = img.width;
    var w = img.naturalWidth;
    var h = img.naturalHeight;
    var radio = w / h;
    if (w > 800) {
        w = 800;
        h = w * (1 / radio);
    }
    if (h > 700) {
        h = 700;
        w = h * radio;
    }
    var imgSize = {
        width: w, height: h
    }
    return imgSize;
}


function updatePreview(c) {
    if (parseInt(c.w) > 0) {
        var canvas = $(".canvas_preview_temp", current_parent)[0];
        var imageObj = $(".img_crop", current_parent)[0];
        var context = canvas.getContext("2d");
        context.drawImage(imageObj, c.x, c.y, c.w, c.h, 0, 0, canvas.width, canvas.height);
        var canvas_preview = $(".canvas_preview", current_parent)[0];
        var ctx = canvas_preview.getContext("2d");
        ctx.drawImage(imageObj, c.x, c.y, c.w, c.h, 0, 0, canvas.width, canvas.height);
        var dataURL = canvas.toDataURL('image/jpeg');
        $('.return_img', current_parent).val(dataURL)

    }
}
function crop(id_image, width, height, default_img) {
    current_width = width;
    current_height = height;
    $('#' + id_image).after('<div style="width: 70px;float:left;cursor:pointer;background: black;height: 30px;color: white;line-height: 30px;text-align:center;" class="but_crop" )>Crop</div>');
//    $('#' + id_image).after('<label>&nbsp;</label><div style="width: 70px;margin-right:10px;float:left;cursor:pointer;background: black;height: 30px;color: white;line-height: 30px;text-align:center;" id="submitimage">Lưu</div>');
    $('#' + id_image).after('<p> <canvas style="border-radius: 5px;border: 5px solid #ccc;" class="canvas_preview" width="' + width + '" height="' + height + '" ></canvas><p>');
    $('#' + id_image).after('<canvas class="c_hide" width="1" height="1" style="display: none;"></canvas>');
    $('#' + id_image).after('<input type="hidden" class="return_img" name="' + id_image + '" />');
    $('#' + id_image).after('<div class="dialog_crop" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100%;height:' + ($(document).height() + 400) + 'px;"><div class="mask" style="width:100%;height:100%;background:black;width:100%;position:absolute;"></div><div style="top: 50px;left:30px;padding:5px;background: white;border-radius: 5px;position:absolute;"><img class="img_crop" src="" /><canvas style="position: absolute;top: 0px;right: -' + (width + 30) + 'px;border-radius: 5px;border: 5px solid #fff;" class="canvas_preview_temp" width="' + width + '" height="' + height + '" ></canvas><div style="padding: 3px 10px;position: absolute;right: -' + (58 + width / 2) + 'px;top:' + (height + 20) + 'px;background: #fff;border-radius: 5px;cursor: pointer;" class="crop_save">Đồng ý</div></div></div>');
    $('#' + id_image).change(function() {
        var parent = $(this).parent();
        var input = this;
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = function(e)
            {
                $('.img_crop', parent).attr('src', e.target.result);
                setTimeout(function() {
                    var canvas_preview = $(".canvas_preview", parent)[0];
                    var ctx = canvas_preview.getContext("2d");
                    var img = $('.img_crop', parent)[0];
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, width, height);
                    var dataURL = canvas_preview.toDataURL('image/jpeg');
                    $('.return_img', parent).val(dataURL);
                    var size = getSize($('.img_crop', parent));
                    var canvas_hide = $('.c_hide', parent)[0];
                    canvas_hide.width = size.width;
                    canvas_hide.height = size.height;
                    var ctx_hide = canvas_hide.getContext("2d");
                    ctx_hide.drawImage(img, 0, 0, img.width, img.height, 0, 0, size.width, size.height);
                    var dataURL_hide = canvas_hide.toDataURL('image/jpeg');
                    $('.img_crop', parent).attr('src', dataURL_hide);
                    $('.img_crop', parent).css({'width': size.width, 'height': size.height});
                }, 100);
            };
        }
    });





    if (typeof default_img != 'undefined') {
        $('document').ready(function() {
            var canvas_avatar = $(".canvas_preview", $('#' + id_image).parent())[0];
            var ctx = canvas_avatar.getContext("2d");
            var imageObj = new Image();
            imageObj.onload = function() {
                ctx.drawImage(imageObj, 0, 0);
            };
            imageObj.src = default_img;

        })
    }

}

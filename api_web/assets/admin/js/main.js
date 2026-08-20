jQuery.validator.setDefaults({
    errorPlacement: function (error, element) {
        error.prepend('<i class="fa fa-times-circle-o"></i> ');
        error.addClass('form-group has-error');
        error.insertAfter(element);
    },
    wrapper: 'div'

});
$(document).ajaxStart(function () {
    $('#loading_content').show();

}).ajaxStop(function () {     
    $('#loading_content').fadeOut(100);
});

function show_dialog(title, cb) {
    $("#dialog").html(title).dialog({
        buttons: {
            Ok: function () {
                cb();
                $(this).dialog("close");
            },
            cancel: function () {
                $(this).dialog("close");
            },
        },
        title: 'CONFIRM',
        modal: true
    });
}

$(document).ready(function () {    
    $('.treeview.active ul.treeview-menu li[action="' + pre2 + '"]').addClass('active');
});
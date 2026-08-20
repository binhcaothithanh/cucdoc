$('.tas-main-nav ul li').hover(function () {
    $(".sub_menu", this).show();
}, function () {
    $(".sub_menu", this).hide();
});
function buy_now(id) {
    window.location = '/order/add_product/' + id;
}
$(".menu_moblie").change(function () { 
    window.location = $(this).val();
});
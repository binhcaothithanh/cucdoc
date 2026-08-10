<div class="cart_sucess">
    <h3>Đặt hàng thành công</h3>
    <p>Mã hóa đơn của bạn là : <b><?php
    $microtime = sprintf('%.3f', microtime(true));
     echo $microtime; ?></b></p>
    <p>Cảm ơn bạn đã đặt hàng tại VuaDan.com, <br />
    Nếu <font color="red">hàng hết</font> => Đơn hàng của bạn sẽ được lưu lại tới khi nhập hàng về chúng tôi sẽ <font color="red">gọi điện ngay</font> cho các bạn để xác nhận
    <br />
    Nếu <font color="red">hàng còn</font> đơn hàng của bạn sẽ được giao trong 2 đến 3 ngày đối với TPHCM, 3 đến 7 ngày làm việc đối với các tỉnh khác</p>

    <div class="checkout-buttons" style="max-width: 100%;">
        <a href="/"><input type="submit" name="ACTION" value="Tiếp tục mua sản phẩm" class="tas-button"></a>
    </div>

</div>

<div class="cart_sucess">
    <h3>Đặt giữ hàng</h3>
    <p>Cảm ơn bạn đã đặt hàng tại VuaDan.com <br />
    <span>Hàng sẽ được gửi tới sau 2 - 4 ngày làm việc của bưu điện.</span>
    <p>Tổng tiền bạn đặt là : <b><?php
    $ante = 0;
    $remain = 0;
    // $total_money = 1000000;
    if(isset($total_money)):
      echo number_format($total_money, 0, ',', ',') . 'đ';


      $ante = round($total_money * 0.3); // Tính 30% và làm tròn
      $remain = $total_money - $ante;

      $ante = number_format($ante, 0, ',', ',');
      $remain = number_format($remain, 0, ',', ',');
    else:
      echo('have not total money');
    endif;
     ?></b></p>
     <p>
       Do vấn đề có quá nhiều đơn hàng đặt mà không nhận nên chúng tôi buộc phải thu 30% (cụ thể là: <?php echo $ante ?>đ) tiền đặt cọc.
      Số tiền còn lại (<?php echo $remain ?>đ) quý khách có thể thanh toán ngay sau khi nhận hàng và kiểm tra đầy đủ.
     </p>
     <p>Quý khách có thể quét mã QR tại đây:
       - Chú ý nội dung chuyển khoản quý khách vui lòng điền sđt để chúng tôi tiện đối chiếu.
     </p>
     <div>
       <img border="0" class="mz_icon" src="../assets/user/images/qr_bank.jpeg" style="width: 20%;" alt="qr">
       <img border="0" class="mz_icon" src="../assets/user/images/tttk.png" style="width: 20%; display: none"  id="myDiv" alt="qr">
      </div>
    <!-- Nếu <font color="red">hàng hết</font> => Đơn hàng của bạn sẽ được lưu lại tới khi nhập hàng về chúng tôi sẽ <font color="red">gọi điện ngay</font> cho các bạn để xác nhận
    <br />
    Nếu <font color="red">hàng còn</font> đơn hàng của bạn sẽ được giao trong 2 đến 3 ngày đối với TPHCM, 3 đến 7 ngày làm việc đối với các tỉnh khác</p> -->
    <p>Hoạc chuyển khoản theo thông tin Tài khoản<a href="#" id="toggleBtn"> =>Ngân hàng</a></p>
    <!-- <div id="myDiv" style="display: none">
      <img border="0" class="mz_icon" src="../assets/user/images/tttk.png" style="width: 20%;" alt="qr">
    </div> -->
    <div class="checkout-buttons" style="max-width: 100%;">
      <p>Sau khi đặt cọc xong quý khách có thể hoàn thành việc đặt mua sản phẩm
        <a href="/">Hoành thành</a>
      </p>
    </div>
</div>
<script>
       $(document).ready(function () {
           $("#toggleBtn").click(function () {
               $("#myDiv").fadeToggle(1000);
           });
       });
   </script>

<div class="content">
    <div class="breadcrumb">
        <ul>
            <li><a href="/">Trang chủ</a> <i class="fa fa-angle-double-right"></i></li>
            <li>Giỏ hàng</li>
        </ul>
    </div>
    <form action="/dat-hang-thanh-cong.html" class="order_info" method="post">
        <div class="tr m_cart">
            <div class="td" style="padding-right:30px">
                <div class="tit_cart">
                    <p><i class="fa fa-truck"></i> GIAO HÀNG TỚI</p>
                </div>
                <p class="note">Bạn vui lòng nhập đầy đủ thông tin bên dưới</p>

                <label>Họ và tên<span>*</span>:</label>
                <input name="name" value="<?php echo @$user['fullname']; ?>"/>
                <label>Số điện thoại<span>*</span>:</label>
                <input name="phone" onkeyup="if (/\D/g.test(this.value))
                            this.value = this.value.replace(/\D/g, '')"  value="<?php echo @$user['phone']; ?>"/>
                <label>Địa chỉ<span>*</span>:</label>
                <input name="address"  value="<?php echo @$user['address']; ?>">
                <label>Tỉnh/thành phố<span>*</span>:</label>
                <select id="rq_province" name="city">
                    <option value="">-Chọn tỉnh/thành phố</option>
                    <?php foreach ($cities as $item): ?>
                        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Quận/huyện<span>*</span>:</label>
                <select id="rq_district" name="district">
                    <option value="">-Chọn Quận/huyện-</option>
                    <?php foreach ($districts as $item): ?>
                        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Email:</label>
                <input name="email" >
                <label>Ghi chú:</label>
                <textarea name="note"></textarea>
                <input type="submit" name="submit" style="display: none;"/>

            </div>
            <div class="td list_order">
                <div class="tit_cart">
                    <p>SẢN PHẨM ĐÃ CHỌN</p>
                </div>
                <p class="note">Bạn vui lòng kiểm tra kỹ đơn hàng trước khi đặt hàng</p>

                <br/>
                <table>
                    <tbody>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Xóa</th>
                            <th class="tdprice">Giá tiền</th>
                            <th>Số lượng</th>
                            <th class="tdprice">Thành tiền</th>
                        </tr>

                        <?php
                         if (!empty($maps_count_product)): ?>
                            <?php $total = 0; ?>
                            <?php foreach ($skus as $item): ?>
                                <?php
                                $count = $maps_count_product[$item['sku_id']];
                                $total+=$item['price'] * $count;
                                ?>
                                <tr class="tdtop">
                                  <?php

                                  if(strpos($item['image'], 'http') === false):
                                   ?>
                                    <td rowspan="2"><img class="thumb_order" src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['img']; ?>"></td>
                                  <?php
                                else:
                                    ?>
                                    <td rowspan="2"><img class="thumb_order" src="<?php echo $item['image']; ?>"></td>
                                    <?php
                                  endif
                                   ?>
                                    <td colspan="4" style="text-align:left">
                                        <?php echo $item['name']; ?>
                                        <span class="info_sp">Kiểu mẫu: <?php echo ($item['size'] ? $item['size'] . ' / ' : '') . $item['color']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span sku_id="<?php echo $item['sku_id']; ?>" class="del">X</span></td>
                                    <td class="tdprice"><span class="fprice"><?php echo number_format($item['price']); ?></span></td>
                                    <td>
                                        <select class="ddl_quan" sku_id="<?php echo $item['sku_id']; ?>">
                                            <?php for ($i = 1; $i < 11; $i++): ?>
                                                <option <?php echo $count == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td class="tdprice"><b><span class="fprice"><?php echo number_format($count * $item['price']); ?></span></b></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="tdbottom1">
                                <td colspan="4" class="tdprice"><b>Tiền hàng:</b></td>
                                <td class="tdprice"><b><span class="fprice grand_total_money" rel="<?php echo $total; ?>"><?php echo number_format($total); ?></span></b></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="tdprice"><b>Mã khuyến mãi:</b></td>
                                <td colspan="2">
                                    <input name="voucher"  placeholder="Nhập mã khyến mãi nếu có" />
                                    <label class="voucher_error" style="display: block;color: red;"></label>
                                    <label class="voucher_success" style="display: block;color: green;"></label>
                                </td>
                            </tr>
                            </tr>
                            <tr class="tdbottom1 voucher_info" style="display: none;">
                                <td colspan="4" class="tdprice"><b>Giảm:</b></td>
                                <td class="tdprice"><b><span class="fprice discount_price" rel="0">0</span></b></td>
                            </tr>
                            <tr class="tdbottom2">
                                <td colspan="4" class="tdprice"><b>Phí vận chuyển :</b></td>
                                <td class="tdprice"><b><span class="fprice shipping_price" rel="0">0</span></b></td>
                            </tr>
                            <tr class="tdbottom3">
                                <td colspan="4" class="tdprice" style="color:red;padding-bottom:15px"><b>Tổng cộng:</b></td>
                                <td class="tdprice" style="color:red;padding-bottom:15px"><b><span class="fprice total_money">...</span></b></td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan="5">Giỏ hàng trống</td></tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <div class="continue">
                    <a href="/" class="back buy">Tiếp tục mua hàng</a>
                    <a class="bt_buy buy buy_order"><i class="fa fa-dropbox"></i> Đặt hàng</a>
                </div>

            </div>
        </div>
    </form>
</div>
<script>
    $('#rq_province').val(<?php echo $user['city']; ?>);
    $('#rq_district').val(<?php echo $user['district']; ?>);
</script>
<script src="/assets/user/js/cart.js"></script>
<script src="/assets/user/js/location.js"></script>

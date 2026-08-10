<div class="page-navigation">
    <div id="idBreadcrumbsTop" style="visibility: visible;">
        <div class="breadcrumb">
            <ul>
                <li><a href="/" class="ajs-bc-home" target="_self"><strong>Home</strong>&nbsp;&gt;</a> </li>
                <li><strong>Giỏ hàng</strong></li>
            </ul>
        </div>
    </div>
</div>
<br/>

<div class="CheckoutCartSection">
    <span id="idShoppingCartGrid">
        <div>
            <table class="checkout-cart" >
                <tbody>
                    <tr>
                        <th align="left" width="">TÊN SẨN PHẨM</th>
                        <th align="middle" width="">XÓA</th>
                        <th align="right" width="">SỐ LƯỢNG</th>
                        <th align="right" width="">GIÁ</th>
                        <th align="right" width="">TỔNG</th>

                    </tr>
                    <?php if (!empty($maps_count_product)): ?>
                        <?php $total = 0; ?>
                        <?php foreach ($skus as $item):
                            $count = $maps_count_product[$item['sku_id']];
                            $total+=$item['price'] * $count;
                            $count_sku_store = $item['count'] ? $item['count'] : COUNT_PRODUCT_CAN_BUY;
                            ?>
                            <tr>
                                <td colspan="" class="cart">
                                    <table  cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td rowspan="2" valign="middle" width="50">
                                                  <?php
                                                  if(strpos($item['img'], 'http') === false):
                                                    ?>
                                                  <img style="width: 40px;" class="cartthumbnail" src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['img']; ?>">
                                            <?php else:
                                              $image_list = explode(',',$item['img']);
                                               ?>
                                                <img style="width: 40px;" class="cartthumbnail" src="<?php echo $image_list[0]; ?>">
                                              <?php endif ?>
                                                </td>
                                                <td ><a href="/san-pham/<?php echo $item['alias'] . '-' . $item['product_id'] . '.html'; ?>" target="_blank"> <?php echo $item['name']; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td > Kiểu Mẫu : <?php echo ($item['size'] ? $item['size'] . ' / ' : '') . $item['color']; ?></td>
                                                <td  align="right"> &nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                                <td align="middle" class="cart"><span sku_id="<?php echo $item['sku_id']; ?>" class="del">X</span></td>
                                <td  class="cart" align="right">
                                    <select class="ddl_quan" sku_id="<?php echo $item['sku_id']; ?>">
                                        <?php for ($i = 1; $i <= $count_sku_store; $i++): ?>
                                            <option <?php echo $count == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td align="right" class="cart"><?php echo (substr($item['price'], 0, strlen($item['price']) - 3)); ?>k</td>
                                <td align="right" class="cart"><?php echo (substr($item['price'] * $count, 0, strlen($item['price'] * $count) - 3)); ?>k</td>

                            </tr>
                        <?php endforeach; ?>
                        <tr class="checkoutMobileTR">
                            <td align="right" colspan="2"><b>Tổng tiền</b></td>
                            <td align="right" colspan="3" class="checkout-cartheading"><b><?php echo (substr($total, 0, strlen($total) - 3)); ?>k</b></td>
                        </tr>

                    <?php else: ?>
                        <tr><td colspan="5">Giỏ hàng trống</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </span>
    <form action="/dat-hang-thanh-cong.html" class="order_info" method="post">
        <div class="td">
            <h1 class="home-heading">Bạn vui lòng nhập đầy đủ thông tin bên dưới</h1>
            <div style="float: left;width: 45%;margin-right: 8%;" class="input">
                <label>Họ và tên<span>*</span>:</label>
                <input type="text" placeholder="Phạm Văn A" name="name" value="<?php echo @$user['fullname']; ?>"/>
                <label>Số điện thoại<span>*</span>:</label>
                <input type="text" placeholder="09012...."  name="phone" onkeyup="if (/\D/g.test(this.value))
                            this.value = this.value.replace(/\D/g, '')"  value="<?php echo @$user['phone']; ?>"/>
                <label style="display: none">Email:</label>
                <input style="display: none" type="text" name="email" >
                <label>Ghi chú:</label>
                <textarea style="height: 100px" placeholder="lưu ý gửi hàng gói kỹ?...vv" name="note"></textarea>
            </div>
            <div style="float: left;width: 45%" class="input">
                <label>Địa chỉ<span>*</span>:</label>
                <input type="text" placeholder="Số 4 ngõ 12 hẻm ...." name="address"  value="<?php echo @$user['address']; ?>">
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
                <div style="clear: both;height: 20px;"></div>
                <div class="checkout-buttons" style="max-width: 100%;">
                    <div style="float: right;">
                        <div style="text-align: center;">
                            <input type="submit" name="submit" value="ĐẶT HÀNG" class="tas-button" >
                        </div>
                    </div>
                    <div style="float: left;">
                        <a href="/"><input type="button"  value="Chọn thêm?" class="tas-button"></a>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div style="clear: both;"></div>
<script src="/assets/user/js/jquery.validate.min.js"></script>
<script>
                    $('#rq_province').val(<?php echo $user['city']; ?>);
                    $('#rq_district').val(<?php echo $user['district']; ?>);
</script>
<script src="/assets/user/js/cart.js"></script>
<script src="/assets/user/js/location.js"></script>

<div class="content">
    <div class="breadcrumb">
        <ul>
            <li><a href="/">Trang chủ</a> <i class="fa fa-angle-double-right"></i></li>        
            <li>Thông tin cá nhân</li>
        </ul>
    </div>
    <div class="tr">        
        <div class="td list_order">
            <div class="tit_cart">
                <p>Thông tin</p><p>
                </p></div>            
            <div style="clear: both;"></div>
            <?php if ($check_error == 1): ?>
                <p style="color: red;margin: 5px 0;"><?php echo validation_errors() . @$msg; ?></p>
            <?php elseif ($check_error == 0): ?>
                <p style="color: green;margin: 5px 0;font-weight: bold;margin-top: 10px;font-size: 18px;">Cập nhật thông tin thành công</p>
            <?php endif; ?>                  
            <form class="order_info update_form"     method="post">
                <label>Họ và tên<span> *</span>:</label>
                <input name="fullname" value="<?php echo $user['fullname']; ?>">                                
                <label>Thay đổi mật khẩu<span> *</span>:</label>
                <input type="password" name="password" id="password">
                <label>Nhập lại mật khẩu<span> *</span>:</label>
                <input type="password" name="repassword">
                <label>Số điện thoại<span> *</span>:</label>
                <input name="phone" disabled="" type="text" value="<?php echo $user['phone']; ?>">
                <label>Địa chỉ<span> *</span>:</label>
                <input name="address" value="<?php echo $user['address']; ?>">
                <label>Tỉnh/thành phố<span> *</span>:</label>
                <select id="rq_province" name="city">
                    <option value="">-Chọn tỉnh/thành phố</option>
                    <?php foreach ($cities as $item): ?>
                        <option <?php echo $user['city'] == $item['id'] ? 'selected' : '' ?> value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Quận/huyện<span> *</span>:</label>
                <select id="rq_district" name="district">
                    <option value="">-Chọn Quận/huyện-</option>
                    <?php foreach ($districts as $item): ?>
                        <option <?php echo $user['district'] == $item['id'] ? 'selected' : '' ?> value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Email:</label>
                <input name="email" disabled="" type="email" value="<?php echo $user['email']; ?>"/>
                <button type="submit" a class="buy_detail login" name="submit">Cập nhật</button>
            </form>

        <div class="history_bill">
            <div class="tit_cart ">
                <p>Lịch sử Đơn Hàng</p>
            </div>
            <table class="table_info">
                <tbody>
                    <tr>
                        <th>Mã</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $item): ?>
                            <tr >
                                <td><?php echo $item['id']; ?></td>
                                <td>
                                    <table class="tb_detail">
                                        <tr>                               
                                            <th>Sản phẩm</th>     
                                            <th>Giá tiền</th>   
                                            <th>SL</th>
                                        </tr>
                                        <?php foreach ($item['childs'] as $order_detail): ?>
                                            <tr>
                                                <td><?php echo $order_detail['name'] . ' ' . $order_detail['attr']; ?></td>
                                                <td><?php echo number_format($order_detail['price']); ?></td>
                                                <td><?php echo $order_detail['count']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>                                      
                                    </table>
                                </td>
                                <td><?php echo date('d-m-Y', strtotime($item['date'])); ?></td>
                                <td><?php echo number_format($item['total']); ?></td>
                                <td><?php echo $status_order[$item['status']]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="10">Không có dữ liệu</td></tr>
                    <?php endif; ?>

                </tbody></table>
        </div>
    </div>
        <div class="td" style="width:264px">
        </div>
    </div>
</div>
<script src="/assets/user/js/location.js"></script> 
<script src="/assets/user/js/userinfo.js"></script> 
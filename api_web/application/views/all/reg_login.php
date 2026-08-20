<div class="breadcrumb">
    <ul>
        <li><a href="/">Trang chủ</a> <i class="fa fa-angle-double-right"></i></li>        
        <li>Đăng nhập & Đăng ký</li>
    </ul>
</div>
<?php if ($action_type == 'login'): ?>
    <div class="tit_cart ">
        <p> ĐĂNG NHẬP</p>
    </div>
    <p class="note">Bạn vui lòng nhập đầy đủ thông tin bên dưới</p>
    <div class="tr m_cart">
        <div class="td">            
            <div style="clear: both;"></div>
            <?php if ($check_error == 1): ?>
                <p style="color: red;margin: 5px 0;">Tên đăng nhập hoặc mật khẩu không đúng</p>
            <?php endif; ?>
            <form method="post" action="/auth/login" class="order_info order_login login_form">
                <label>Số điện thoại :</label>
                <input name="phone" type="text">
                <label>Mật khẩu :</label>
                <input type="password" name="password">
                <button type="submit" a class="buy_detail login" name="submit">Login</button>
            </form>
        </div>
        <div class="td">
            <div class="noacc">
                <b>Bạn chưa có tài khoản?</b><br><br>
                <a href="/auth/reg"><img src="/assets/user/images/dk.jpg"></a>

            </div>
        </div>
    </div>
<?php else: ?>
    <div class="tit_cart">
        <p>ĐĂNG KÝ</p><p></p>
    </div>
    <p class="note">Bạn vui lòng không bỏ trống thông tin dấu ( * )</p>
    <div class="tr m_cart">
        <div class="td list_order">

            <div style="clear: both;"></div>
            <?php if ($action_type == 'reg' && $check_error == 1): ?>
                <p style="color: red;margin: 5px 0;"><?php echo validation_errors() . @$msg; ?></p>
            <?php endif; ?>                  
            <form class="order_info order_login reg_form" action="/auth/reg" method="post">
                <label>Họ và tên<span> *</span>:</label>
                <input name="fullname">                                
                <label>Mật khẩu<span> *</span>:</label>
                <input type="password" name="password" id="password">
                <label>Nhập lại mật khẩu<span> *</span>:</label>
                <input type="password" name="repassword">
                <label>Số điện thoại<span> *</span>:</label>
                <input name="phone" type="phone">
                <label>Địa chỉ<span> *</span>:</label>
                <input name="address">
                <label>Tỉnh/thành phố<span> *</span>:</label>
                <select id="rq_province" name="city">
                    <option value="">-Chọn tỉnh/thành phố</option>
                    <?php foreach ($cities as $item): ?>
                        <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Quận/huyện<span> *</span>:</label>
                <select id="rq_district" name="district">
                    <option value="">-Chọn Quận/huyện-</option>

                </select>
                <label>Email:</label>
                <input name="email" type="email"/>
                <button type="submit" a class="buy_detail login" name="submit">Đăng ký</button>
            </form>
        </div>
        <div class="td" style="padding:20px;">
            <div class="noacc" style="text-align:left">


                <b>Bạn đã có tài khoản</b><br><br>
                <?php if ($check_error == 1): ?>
                    <p style="color: red;margin: 5px 0;">Tên đăng nhập hoặc mật khẩu không đúng</p>
                <?php endif; ?>
                <form method="post" action="/auth/login" class="order_info order_login login_form">
                    <label>Số điện thoại :</label>
                    <input name="phone" type="text">
                    <label>Mật khẩu :</label>
                    <input type="password" name="password">
                    <button type="submit" a class="buy_detail login" name="submit">Login</button>
                </form>
            </div>
        </div>

    </div>
<?php endif; ?>
<script src="/assets/user/js/location.js"></script> 
<script src="/assets/user/js/reg_login.js"></script> 
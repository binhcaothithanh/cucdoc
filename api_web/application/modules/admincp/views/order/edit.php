<div class="content-wrapper">
    <section class="content-header">
        <h1>Duyệt đơn hàng</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>order">Danh sách đơn hàng</a></li>
        </ol>
    </section>
    <section class="content">
        <?php $check_status = check_order($order); ?>
        <form id="form" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                            Cập nhật thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo @$msg; ?>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-body">
                            <p>
                                <b>Thời gian đặt hàng : <?php echo date('d-m-Y H:i:s', strtotime($order['date'])); ?></b>
                            </p>
                            <br/>
                            <div class="form-group">
                                <label for="cat_id">Trạng thái</label>
                                <?php if ($check_status): ?>
                                    <select class="form-control" name="status">
                                        <?php echo $order['status'] == 'had_invoiced' ? '<option value="had_invoiced" selected>Đã xuất hoá đơn</option> ' : ''; ?>
                                        <?php echo $order['status'] == 'shipping' ? '<option value="shipping" selected>Đang vận chuyển</option> ' : ''; ?>
                                        <option value="approved">Chờ in</option>
                                        <option  <?php echo $order['status'] == 'order' ? 'selected' : ''; ?>  value="order">Đơn hàng mới</option>

                                        <option  <?php echo $order['status'] == 'wait_pack' ? 'selected' : ''; ?>  value="wait_pack">Chờ đóng gói</option>
                                        <option  <?php echo $order['status'] == 'Send_Deliver' ? 'selected' : ''; ?>  value="Send_Deliver">Đưa tới hãng vc</option>

                                        <option  <?php echo $order['status'] == 'unknown' ? 'selected' : ''; ?> value="unknown">Chưa liên lạc</option>
                                        <option  <?php echo $order['status'] == 'return' ? 'selected' : ''; ?> value="return">Trả Hàng</option>
                                        <option <?php echo $order['status'] == 'waitting_pay' ? 'selected' : ''; ?> value="waitting_pay">Chờ chuyển khoản</option>
                                        <option <?php echo $order['status'] == 'waitting_product' ? 'selected' : ''; ?> value="waitting_product">Chờ đổi sản phẩm</option>
                                        <option <?php echo $order['status'] == 'cancel' ? 'selected' : ''; ?>  value="cancel">Huỷ</option>
                                        <option <?php echo $order['status'] == 'alo-ed' ? 'selected' : ''; ?> value="alo-ed" >alo-ed</option>
                                    </select>
                                <?php else: ?>
                                    <select class="form-control" disabled="disabled" name="status">
                                        <option value="<?php echo $order['status'] ?>"><?php echo $status_order[$order['status']]; ?></option>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label>Phương thức vận chuyển</label>
                                <select class="form-control"  name="shipping_type">
                                    <option value="none">---Phương thức vận chuyển---</option>
                                    <option value="post_office" <?php echo $order['shipping_type'] == 'post_office' ? 'selected' : ''; ?>>Bưu điện</option>
                                    <option value="f_shipping" <?php echo $order['shipping_type'] == 'f_shipping' ? 'selected' : ''; ?>>Chuyển phát nhanh</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiền khách trả</label>
                                <input type="text" class="format_number form-control" value="<?php echo $order['payed_money'] ?>" name="payed_money"/>
                            </div>
                            <div class="form-group">
                                <label>Tiền ship</label>
                                <input type="text" class="format_number form-control" value="<?php echo $order['shipping_price'] ?>" name="shipping_price"/>
                            </div>
                            <div class="form-group">
                                <label>Giảm giá</label>
                                <input type="text" readonly="" voucher_price="<?php echo $order['voucher_price']; ?>" voucher_type="<?php echo $order['voucher_type']; ?>" class="form-control" value="<?php echo number_format($order['voucher_price']) . ' ' . $order['voucher_type']; ?>" name="voucher"/>
                            </div>
                            <div class="form-group" style="font-size: 30px;color: #ff4949">
                                Tổng trả : <b id="total_pay"></b>
                            </div>
                            <br/>
                            <div class="box-footer" style="margin-bottom: 10px;">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="box box-primary box-success">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Tên khách hàng</label>
                                    <input name="name" class="form-control" value="<?php echo $order['name']; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address"   class="form-control" value="<?php echo $order['address']; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại</label>
<font size="20px" ><a href="tel:<?php
$order['phone'] = substr($order['phone'], 0, 4) . '.' . substr($order['phone'], 4,3) . '.' . substr($order['phone'], 7);

  echo $order['phone'];?>">&nbsp; &nbsp;&nbsp;<?php echo $order['phone'];?></a></font>
                                    <input  name="phone" class="form-control" value="<?php echo $order['phone']; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>Thành phố</label>
                                    <select name="city" id="rq_province" class="form-control">
                                        <?php foreach ($cities as $item): ?>
                                            <option <?php echo $item['name'] == $order['city'] ? 'selected' : ''; ?> ><?php echo $item['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>Quận huyện</label>
                                    <select id="rq_district" name="district" class="form-control">
                                        <?php foreach ($districts as $item): ?>
                                            <option <?php echo $item['name'] == $order['district'] ? 'selected' : ''; ?> ><?php echo $item['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú của khác hàng</label>
                                    <textarea  name="note" style="width: 500px;height: 50px;"><?php echo $order['note']; ?></textarea><br />
                                    <label>History:</label><br />
                                    <textarea readonly name="log_admin" style="width: 400px;height: 100px;"><?php echo $order['log_admin']; ?></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input class="format_number" type="text" id="add_product" style="width: 300px !important;" placeholder="Nhập mã sản phẩm"/>
                    <table id="order_product">
                        <thead>
                            <tr>
                                <th>Sản phẩm đặt mua</th>
                                <th>Thuộc tính</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $count_product = count($order_details);
                            ?>
                            <?php foreach ($order_details as $sku_order): ?>
                                <?php
                                $sku_store = (@$skus[$sku_order['sku_id']]);
                                $product = $products[$sku_order['product_id']];
                                $sku_other_temp = $skus_other[$sku_order['product_id']];
                                ?>
                                <tr product_id="<?php echo $sku_order['product_id']; ?>" id="<?php echo $sku_order['id']; ?>">
                                    <td>
                                        <a style="<?php echo $count_product < 2 ? 'display:none' : ''; ?>" href="javascript:void(0)" onclick="del_product(<?php echo $sku_order['id']; ?>, this)" class="delete-cart-item" title="Xóa sản phẩm này?">&nbsp;</a>
                                        <img src="/assets/upload/product/<?php echo $product['folder'] . '/' . $product['image'] ?>" alt="" width="50">
                                        <?php echo '<a target="_bank" href="/' . ADMIN_URL .'product/edit/' . $product['id'].'">' . $sku_order['name'] . '</a>'; ?>
                                    </td>

                                    <td>
                                        <?php if ($check_status): ?>
                                            <select style="" class="attribute">
                                                <?php foreach ($sku_other_temp as $item_temp): ?>
                                                    <option price="<?php echo $product['price']; ?>" <?php echo (($item_temp['id'] == $sku_order['sku_id']) ? 'selected' : ''); ?> value="<?php echo $item_temp['id']; ?>"><?php echo ($item_temp['size'] ? $item_temp['size'] . ' / ' : '') . $item_temp['color']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <select style="display: none;" class="attribute">
                                                <option price="<?php echo $sku_order['price']; ?>"></option>
                                            </select>
                                            <?php echo $sku_order['attr']; ?>
                                        <?php endif; ?>

                                    </td>
                                    <td class="price" rel="<?php echo $sku_order['price']; ?>"><?php echo number_format($sku_order['price']); ?></td>
                                    <td>
                                        <?php if ($check_status): ?>
                                            <input class="ddl_quan valid format_number" value="<?php echo $sku_order['count']; ?>" />
                                        <?php else: ?>
                                            <input disabled="true" class="ddl_quan valid format_number " value="<?php echo $sku_order['count']; ?>" />
                                        <?php endif; ?>
                                    </td>
                                    <td class="price_final price">...</td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h3 style="float: right;margin-right: 60px;margin-top: 7px;">Tổng tiền: <span style="font-size: 24px;" class="price total_money">...</span></h3>
                </div>
            </div>
        </form>
    </section>

</div>
<script>
    var total_order =<?php echo $order['total']; ?>;
    var order_id = <?php echo $order['id']; ?>;
    function calc_total_pay() {
        var payed_money = parseInt($('input[name="payed_money"]').autoNumeric('get'));
        var voucher_price = parseInt($('input[name="voucher"]').attr('voucher_price'));
        if (voucher_price && $('input[name="voucher"]').attr('voucher_type') == '%')
            voucher_price = total_order * voucher_price / 100;
        var shipping_price = parseInt($('input[name="shipping_price"]').autoNumeric('get'));
        $('#total_pay').html(formatDollar(total_order + shipping_price - payed_money - voucher_price));
    }
    $('input[name="payed_money"]').change(function () {
        calc_total_pay();
    });
    $('input[name="shipping_price"]').change(function () {
        calc_total_pay();
    });
    function formatDollar(num) {
        var p = num + '';
        return  p.split("").reverse().reduce(function (acc, num, i, orig) {
            return  num + (i && !(i % 3) ? "," : "") + acc;
        }, "");
    }
    function calc_price() {
        var total = 0;
        $('#order_product tbody tr').each(function () {
            var price = parseInt($('select.attribute option:selected', this).attr('price'));
            var count = $('.ddl_quan', this).autoNumeric('get');
            var money = price * count;
            total += money;
            $('.price', this).html(formatDollar(price));
            $('.price_final', this).html(formatDollar(money));
        });
        $(".total_money").html(formatDollar(total));
        total_order = total;
        calc_total_pay();
    }
    $('.format_number').autoNumeric('init', {aPad: false});

    calc_price();
    $('#add_product').keypress(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var pro_id = $(this).val();
            if (pro_id != '') {
                $.post('<?php echo base_url() . ADMIN_URL; ?>order/add_product', {order_id: order_id, pro_id: pro_id}, function (data) {
                    if (data == 1) {
                        alert('Sản phẩm không tồn tại hoặc đã hết hàng');
                    } else {
                        $('#order_product tbody').append(data);
                        $('.format_number').autoNumeric('init', {aPad: false});
                        $(".delete-cart-item").show();
                        calc_price();
                    }
                });
            }
        }
    });
    function del_product(id, _this) {
        show_dialog('Bạn có thật sự muốn xoá sản phẩm id = ' + id + " không", function () {
            $.post('<?php echo base_url() . ADMIN_URL; ?>order/del_product', {id: id, order_id: order_id}, function (result) {
                if (result == 1) {
                    $(_this).parents('tr').remove();
                    calc_price();
                    if ($('#order_product tbody tr').length == 1) {
                        $('#order_product tbody tr .delete-cart-item').hide();
                    }
                } else if (result == 2) {

                } else {
                    alert(result);
                }
            });
        });

    }

    $('#order_product').on('change', 'input.ddl_quan', function () {
        if ($(this).val() != 0) {
            $(this).css({'border': ''})
        } else {
            $(this).css({'border': '1px solid red'});
        }
        var parent = $(this).parents('tr');
        $.post('<?php echo base_url() . ADMIN_URL; ?>order/change_order_product', {id: $(parent).attr('id'), order_id: order_id, count: $(this).autoNumeric('get')}, function (result) {
            if (result == 1) {
                calc_price();
            } else {
                if (result) {
                    alert(result);
                }

            }

        });
    });
    $('#order_product').on('change', 'select.attribute', function () {
        var tr = $(this).parents('tr');
        var data = {id: $(tr).attr('id'), order_id: order_id, news_sku_id: $(this).val()};
        $.post('<?php echo base_url() . ADMIN_URL; ?>order/change_sku_id', {id: $(tr).attr('id'), order_id: order_id, news_sku_id: $(this).val()}, function (result) {
            if (result != 1) {
                alert(result);
            } else {
                calc_price();
            }
        });
        return false;
    });
    $('button.submit').click(function () {

        if ($('select[name="status"]').val() == 'approved') {
            if ($('select[name="shipping_type"]').val() == 'none') {
                alert('Vui lòng chọn hình thức vận chuyển');
                return false;
            }
        }
    });

<?php echo $check_status === false ? "  $('input.submit').remove();$('input,select,textarea').attr('disabled', 'disabled')" : ''; ?>

    var admin_url = "<?php echo ADMIN_URL; ?>";
</script>
<script src="/assets/admin/js/location.js"></script>
<style>

    table {
        width: 100%;
        border-collapse: collapse;
    }
    .price{font-size: 15px;font-weight: bold;color: #00a200;line-height: 20px}
    /* Zebra striping */
    tr:nth-of-type(odd) {
        background: #eee;
    }
    th {
        background: #333;
        color: white;
        font-weight: bold;
    }
    #order_product td, #order_product th {
        padding: 6px;
        border: 1px solid #ccc;
        text-align: left;
    }
    .delete-cart-item {
        width: 20px;
        height: 20px;
        display: inline-block;
        background: transparent url(/assets/admin/images/delete.png) no-repeat 0 0;
    }
    img {
        vertical-align: middle;
    }
    #order_product td select{width: 50px;}
    <?php echo $check_status == false ? '.delete-cart-item{display: none;}' : ''; ?>
    select:disabled {
        background: #dddddd;
    }
    .process_order .largeframe p{margin-bottom: 5px;}
    .process_order .largeframe label{text-align: left;float: none;}
    .form_default label{display: block;font-weight: bold;width: 153px !important;}
    #order_product td select,#order_product td input{
        border-radius: 3px;
        width: 140px;
    }
</style>

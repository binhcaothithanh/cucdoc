
<div class="content-wrapper">    
    <section class="content-header">
        <h1>Cập nhật đơn hàng đã nhận tiền</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
            <li class="active">Cập nhật đơn hàng đã nhận tiền</li>
        </ol>
    </section>    
    <section class="content">
        <?php if ($check_error == 1): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $msg; ?>                
            </div>
        <?php endif; ?>
        <?php if ($check_error == 0): ?> 
            <?php
            $html_ok = $html_errror = $html_not_found = '';
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" id="list_ajax">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">                  
                                        <th >Mã đơn hàng</th>          
                                        <th >Mã bưu điện</th>          
                                        <th >Tên khách</th>
                                        <th >Tổng tiền</th>
                                        <th >Tổng thu hộ</th>                        
                                        <th >Thực thi</th>                                     
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php foreach ($shipping_code as $k => $v): ?>
                                        <?php
                                        $order = @$orders[$v];
                                        $discount = $order['voucher_price'];
                                        if($discount&&$order['voucher_type']=='%')
                                            $discount=$order['total']*$discount/100;
                                        $total = $order['total']-$discount + $order['shipping_price'] - $order['payed_money'];
                                        if (!empty($order)) {
                                            if ($total == $prices[$k]) {
                                                $html_ok.=' <tr class="gradeC">                       
                                                                <td><a target="_blank" href="order/edit/' . $order['id'] . '">' . $order['shipping_code'] . '</a></td>
                                                                <td>' . $order['office_code'] . '</td>
                                                                <td>' . $order['name'] . '</td>
                                                                <td>' . number_format($total) . '</td>
                                                                <td>' . number_format($prices[$k]) . '</td>
                                                                <td>
                                                                    <a class="delete" href="javascript:void(0)">DELETE</a>                    
                                                                    <input type="hidden" class="shipping_code" value="' . $order['id'] . '"/>
                                                                </td>
                                                            </tr>';
                                            } else {
                                                $html_errror.=' <tr class="gradeC price_error">                       
                                                                    <td><a target="_blank" href="/' . ADMIN_URL . 'order/edit/' . $order['id'] . '">' . $order['shipping_code'] . '</a></td>
                                                                   <td>' . $order['office_code'] . '</td>
                                                                    <td>' . $order['name'] . '</td>
                                                                    <td>' . number_format($total) . '</td>
                                                                    <td>' . number_format($prices[$k]) . '</td>
                                                                    <td>
                                                                        <a class="delete" href="javascript:void(0)">DELETE</a>                    
                                                                        <input type="hidden" class="shipping_code" value="' . $order['id'] . '"/>
                                                                    </td>
                                                                </tr>';
                                            }
                                        } else {
                                            $html_not_found.='<tr class="gradeC price_error"><td>' . $v . '</td><td colspan="10">Không tồn tại mã đơn hàng này</td></tr>';
                                        }
                                        ?>               

                                    <?php endforeach; ?>  
                                    <?php
                                    echo $html_errror;
                                    echo $html_not_found;
                                    echo $html_ok;
                                    ?>
                                </tbody>      
                            </table>
                        </div>        
                    </div>        
                    <input type="submit" name="submit" id="submit_success" class="button btn btn-block btn-success" value="Cập nhật đơn hàng thành công" style="width: 210px;"/>                
                </div>       

            </div>        
            <br/>

            <script>
                $('.tr')
                var type = "<?php echo $type; ?>";
                $('td a.delete').click(function () {
                    $(this).parents('tr').remove();
                });
                $('#submit_success').click(function () {
                    if ($('input.shipping_code').length > 0) {
                        var shipping_code = [];
                        $('input.shipping_code').each(function () {
                            shipping_code.push($(this).val())
                        });
                        $.post('<?php echo base_url() . ADMIN_URL; ?>update_shipping/ajax_update_success', {type: type, shipping_code: shipping_code}, function (result) {
                            if (result == 1) {
                                alert('Cập nhật thành công đơn hàng');
                                window.location = '<?php echo base_url() . ADMIN_URL; ?>update_shipping/update_order_success';
                            } else {
                                alert('Lỗi hệ thống vui lòng thử lại');
                            }

                        });
                    } else {
                        alert('Không có gì để cập nhật');
                    }


                });
            </script>

        <?php endif; ?>


        <?php if ($check_error != 0): ?>


            <form id="form" action="" method="post" >    
                <div class="row">            
                    <div class="col-md-12">                     

                        <div class="box box-primary box-success">                     
                            <div class="box-body col-md-4">
                                <div class="form-group">
                                    <label for="shipping_code">Mã đơn hàng</label>
                                    <textarea class="form-control" name="shipping_code"  style="height: 350px;"></textarea>
                                </div>
                            </div>      
                            <div class="box-body col-md-4">
                                <div class="form-group">
                                    <label for="prices">Tiền nhận</label>
                                    <textarea name="prices"  class="form-control" style="height: 350px;"></textarea>
                                </div>
                            </div> 
                        </div> 
                    </div>
                    <div  class="col-md-12">   
                        <div class="box box-primary box-success">                             
                            <div class="box-body">
                                <div class="form-group">
                                    <select class="form-control"  style="width: 20%" name="shipping_type">
                                        <option value="">---Chọn hình thức giao hàng---</option>
                                        <option <?php echo @$_POST['shipping_type'] == 'f_shipping' ? 'selected' : ''; ?> value="f_shipping">Giao hàng nhanh</option>
                                        <option <?php echo @$_POST['shipping_type'] == 'post_office' ? 'selected' : ''; ?> value="post_office">Đi bưu điện</option>
                                    </select>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>

                    </div>               
                </div>          

            </form>
            <style>
                label.error{text-indent:0; }
            </style>
            <script>
                $("#form").validate({
                    rules: {
                        shipping_type: {required: true},
                    }
                });
            </script>

        <?php endif; ?>

    </section>

</div>

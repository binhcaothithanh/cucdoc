<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">                  
                    <th>STT</th>
                    <th>Thông tin khách</th>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>                                                           
                </tr>
            </thead>
            <tbody>    
                <?php if (!empty($results)): ?>
                    <?php $i = 0; ?>
                    <?php foreach ($results as $item): ?>
                        <tr>    
                            <td><?php echo ++$i; ?></td>
                            <td>
                                <p><?php echo $item['name'] . ' --- ' . $item['phone'] . ' - ' . $item['device_type'] . ' - ' . date('d/m/Y', strtotime($item['date'])); ?></p>
                                <p><?php echo $item['address'] . ' , ' . $item['district'] . ' , <span class="' . ($item['city'] == 'TP.Hồ Chí Minh' ? 'location_current' : 'location_other') . '">' . $item['city'] . '</span>' . (intval($item['shipping_date']) ? ' - ' . date('d-m-Y', strtotime($item['shipping_date'])) : ''); ?></p>                        
                            </td>		                    
                            <td>
                                <p class="location_current"><?php echo $item['shipping_code']; ?></p>
                                <p class="location_other"><?php echo $item['office_code']; ?></p>
                            </td>                            
                            <td>
                                <span class="format_number"><?php echo $item['total']; ?></span>
                                <?php
                                $total = $discount = 0;
                                if ($item['voucher_price']) {
                                    $discount = $item['voucher_price'];
                                    if ($item['voucher_type'] == '%')
                                        $discount = $item['total'] * $discount / 100;
                                }
                                $total = $item['total'] - $discount;
                                ?>
                                <p><span class="format_number location_current"><?php echo $total + $item['shipping_price'] - $item['payed_money']; ?></span></p>
                            </td>  
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>      


        </table>

    </div>
</div>

<script>

    $('.format_number').autoNumeric('init', {aPad: false, vMax: 99999999, vMin: -999999999});
</script>
<div class="box-body">Total record: <b> <?php echo($total); ?> </b> <br />
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Thông tin khách</th>
                    <th>so lan mua</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 if (!empty($results)): ?>
                    <?php foreach ($results as $item):
                       $item['phone'] = substr($item['phone'], 0, 4) . '.' . substr($item['phone'], 4,3) . '.' . substr($item['phone'], 7);
                   // echo('<pre>');
                   // var_dump($item);
                   // exit;

                    ?>
                        <tr class="gradeC status_<?php echo $item['status']; ?>">

                            <td> <a target="_blank" href="<?php echo base_url() . ADMIN_URL . "order/edit/{$item['id']}"; ?>"><?php echo $item['id']; ?></a></td>
                            <td>
                                <p><?php echo $item['name'] . ' --- <font size="5pt" color="red">' . $item['phone'] . '</font> -' . ' <b>Ngày Đặt:</b> ' . $item['date']; ?></p>
                                <p><?php echo $item['address'] . ' , ' . $item['district'] . ' , <span class="' . ($item['shipping_type'] == 'f_shipping' ? 'location_current' : 'location_other') . '">' . $item['city'] . '</span>' . ' (<font color="blue">' . $item['product_names'] . '</font>)'; ?></p>
                            </td>
                            <td>
                                <p class="location_current"><?php echo $item['count_phone']; ?><br/>
                                  <?php
                                  if(strlen($item['ip']) < 17 ):
                                   echo '<font size="0.5pt" color="#BF00FF"> IP: ' . $item['ip'] . '<br/>(count_ip: '. $item['count_ip'] .')</font>' ;
                                 endif; ?>
                                </p>
                            </td>
                            <td>
                                <span class="format_number"><?php echo number_format($item['total']); ?></span>
                                <?php
                                $total = $discount = 0;
                                if ($item['voucher_price']) {
                                    $discount = $item['voucher_price'];
                                    if ($item['voucher_type'] == '%')
                                        $discount = $item['total'] * $discount / 100;
                                }
                                $total = $item['total'] - $discount;
                                ?>
                                <p><span class="format_number location_current"><?php echo number_format($total + $item['shipping_price'] - $item['payed_money']); ?></span></p>
                            </td>
                            <td class="<?php echo $item['status'];?>">
                                <?php echo $status_order[$item['status']]; ?>
                                <p>
                                    <?php
                                    if ($item['status'] == 'shipping') {
                                        echo date('d-m-Y', strtotime($item['shipping_date']));
                                    } elseif ($item['status'] == 'success' || $item['status'] == 'fail') {
                                        echo intval($item['date_success']) ? date('d-m-Y', strtotime($item['date_success'])) : '';
                                    }
                                    ?>
                                </p>
                            </td>
                            <td>
                                <a href="<?php echo base_url() . ADMIN_URL . "order/edit/{$item['id']}"; ?>">EDIT</a> |
                                <a href="javascript:void(0)" onclick="del(<?php echo $item['id'];?>)">DELETE</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>


        </table>

    </div>
</div>
<div class="col-md-4 col-md-offset-5">
    <div class="pagination">
        <?php echo $links; ?>
    </div>
</div>

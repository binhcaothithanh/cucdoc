<style>
    table{margin-bottom: 10px;color: #000;border: 2px solid #000;}
    table,tr{width: 100%;}
    td{border: 1px solid #000;}
    td{padding: 5px;}
    .bloder{font-weight: bolder;}

</style>
<?php $date = date('d/m'); ?>
<?php foreach ($orders as $item): ?>
    <table>
        <tr class="bloder">
            <td style="width: 50%">
                ZILANDO – ZILANDO.VN  <span style="float: right;font-size: 28px;"><?php echo $date; ?></span><br/>
                ĐC: 1/6 Quách Văn Tuấn, P12, Q.Tân Bình, TP.HCM<br/>
                ĐIỆN THOẠI: 1900 6420
            </td>        
            <td>
                NHẬN: <?php echo $item['name'] . '-' . $item['shipping_code']; ?><br/>
                ĐC: <?php echo $item['address'] . ' - ' . $item['district'] . ' - ' . $item['city'] ?><br/>
                ĐIỆN THOẠI: <?php echo $item['phone'] ?>
            </td>    

        </tr>
        <tr  class="bloder">
            <td colspan="2">
                <?php
                $total = 0;
                foreach ($item['childs'] as $k => $v) {
                    $price = $v['count'] * $v['price'];
                    $total+=$price;
                    echo $k + 1 . "[AN{$v['product_id']}] {$v['name']} ({$v['attr']}) x {$v['count']} cái = " . number_format($price) . '<br/>';
                }
                $voucher_price = $item['voucher_price'];
                if ($voucher_price && $item['voucher_type'] == '%')
                    $voucher_price = $total * $voucher_price / 100;
                ?>
                <p>
                    Tiền hàng : <?php echo number_format($total); ?> đ  
                    <?php echo $item['voucher_price'] ? '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Giảm : ' . number_format($item['voucher_price']) . ' ' . $item['voucher_type'] : ''; ?>
                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Phí vận chuyển : <?php echo number_format($item['shipping_price']); ?> đ
                    <?php echo $item['payed_money'] ? '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Khách trả :' . number_format($item['payed_money']) . ' đ' : ''; ?> 
                </p>
                <?php echo $item['note'] ? '<p>Ghi chú: ' . $item['note'] : '</p>'; ?>
            </td>
        </tr>
        <tr style="font-size: 15px;">
            <td colspan="2">
                + Hàng đã được niêm phong, khách hàng vui lòng thanh toán trước khi mở hàng.<br/>
                + Yêu cầu BƯU ĐIỆN: Nếu không phát được, vui lòng liên lạc người gởi, không được tự ý chuyển hoàn.
            </td>
        </tr>

        <td colspan="2">
            <div style="margin-top: 5px;;float: <?php echo $item['shipping_type'] == 'f_shipping' ? 'right' : 'left'; ?>;width: 25%;text-align: center;">
                <img style="margin-top: 10px;" src="<?php echo base_url() . ADMIN_URL . 'barcode?text=' . $item['shipping_code']; ?>"/>               
            </div>
            <div style="float: left;font-size: 20px;font-weight: bold;line-height: 60px;">
                TỔNG TIỀN THU HỘ (COD) : <b style="font-size: 35px;"><?php echo number_format($total + $item['shipping_price'] - $item['payed_money'] - $voucher_price) ?></b>
            </div>
        </td>    
    </table>

<?php endforeach; ?>
<style type="text/css">
    table { page-break-inside:auto;page-break-inside:avoid; }   
    @media print {
        footer {page-break-after: always;}
    }

    p{margin: 0;padding: 0;margin-top: 5px;}
</style>
<script src="<?php echo base_url(); ?>../assets/admin/js/jquery-1.8.0.min.js" type="text/javascript" ></script> 
<script>
//    var height = 800;
//    var current_height = 0;
//    $('table').each(function (index) {
//        current_height += $(this).height();
//        if (current_height > height) {
//            $(this).before('<footer></footer>');
//            current_height = $(this).height();
//
//        }
//    });

    function printpage() {
        window.print();
    }
    printpage();
</script>
<?php
// echo('----------------------------------------------------------------------');
// if($transaction['count_product_after'] == ''){
//   die ('rong');
// }else{
//   die('abc' . $transaction['count_product_after'] . 'aaa');
// }
// die('----------------------------------------------------------------------');

$prize_default = 0;
$prize_default1 = 0;
$prize_default2 = 0;
foreach($constant_list as $eachConstant){
  if($eachConstant['constant_name'] == 'prize'){
    $prize_default = $eachConstant['constant_value'];
  }
  if($eachConstant['constant_name'] == 'prize'){
    $prize_default1 = $eachConstant['constant_value'];
  }
  if($eachConstant['constant_name'] == 'prize2'){
    $prize_default2 = $eachConstant['constant_value'];
  }
  // if($eachConstant['constant_name'] == 'money_add_on'){
  //   $money_default = $eachConstant['constant_value'];
  // }
}
//
//
// echo('<pre>');
// var_dump($constant_list);
// die;
 ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Xử lý transaction</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>StudentTransaction">Danh sách Transaction</a></li>
        </ol>
    </section>
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                            Xử lý transaction thành công
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
                            <div class="form-group">
                              <label for="roles">Students</label><br/>
                              <div style="clear: both;"></div>
                              <p style="font-weight: bold; font-size: 20px">
                                <?php echo($transaction['student_name']) ?>
                              </p>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="addon_money">Tiền Gửi</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" id="addon_money" name="addon_money" value="<?php echo($transaction['addon_money']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn (<?php echo number_format($prize_default1) ?>) đi</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" id="count_product_before" name="count_product_before" value="<?php echo($transaction['count_product_before']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn (<?php echo number_format($prize_default2) ?>) đi</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" id="count_product_before2" name="count_product_before2" value="<?php echo($transaction['count_product_before2'] == '' ? '0' : $transaction['count_product_before2']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Ghi Chú</label><br />
                                <textarea id="note" name="note" rows="4" cols="50"><?php echo $transaction['note'] ?></textarea>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn (<?php echo number_format($prize_default1) ?>) về</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" name="count_product_after" id="count_product_after" value="<?php echo($transaction['count_product_after'] == '' ? '0' : $transaction['count_product_after']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn (<?php echo number_format($prize_default2) ?>) về</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" name="count_product_after2" id="count_product_after2" value="<?php echo($transaction['count_product_after2'] == '' ? '0' : $transaction['count_product_after2'])  ?>" >
                            </div>
                        </div>

                        <div class="box-footer">
                            <a id="btnCalulator" href="javascript: document.body.scrollIntoView(false);"class="btn btn-primary">Tính Tiền</a>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Tiền Bán Được = (số hàng đi - số hàng về) x đơn giá mỗi loại</label>
                                <input type="text" class="form-control"  id="TotalMoneySell" name="TotalMoneySell" value="<?php echo($transaction['total_sell']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Tổng tiền về = Tiền gửi + (số hàng đi - số hàng về) x đơn giá mỗi loại</label>
                                <input type="text" class="form-control"  id="TotalMoneyBack" name="TotalMoneyBack" value="<?php echo($transaction['total_money_back']) ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Tổng đơn bán = Số hàng đi - số hàng về</label>
                                <input type="text" class="form-control"  id="TotalProductSell" name="TotalProductSell" value="<?php echo($transaction['totalproductsell']) ?>" >
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit"  class="btn btn-primary">Hoàn Thành</button>
                            <a href="/<?php echo ADMIN_URL; ?>StudentTransaction"class="btn btn-primary">Cancel</a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

</div>
<script>


$('#btnCalulator').click(function () {
  Caculating();
});

$( "#count_product_after" ).focusout(function() {
 // Caculating();
})

$( "#count_product_after2" ).focusout(function() {
 Caculating();
})


    $('select[name="role"]').change(function () {
        if ($(this).val() == 'admin') {
            $(".roles").hide();
        } else {
            $(".roles").show();
        }
    });
     $('select[name="role"]').change();



   function Caculating(){

         //Tiền về = Tiền gửi + (số hàng đi - số hàng về) x 18000
         var default_prize =  parseInt(<?php echo $prize_default; ?>);
         var default_prize2 =  parseInt(<?php echo $prize_default2; ?>);
         var addon_money  = parseInt($('#addon_money').val());
         if($('#count_product_before').val() != ''){
           var product_before = parseInt($('#count_product_before').val());
         }else{
           var product_before = 0;
         }

         if($('#count_product_before2').val() != ''){
           var product_before2 = parseInt($('#count_product_before2').val());
         }else{
           var product_before2 = 0;
         }

         if($('#count_product_after').val() != ''){
           var product_after = parseInt($('#count_product_after').val());
         }else{
           var product_after = 0;
         }

         if($('#count_product_after2').val() != ''){
           var product_after2 = parseInt($('#count_product_after2').val());
         }else{
           var product_after2 = 0;
         }
         // var product_after2 = parseInt($('#count_product_after2').val());

         //TotalMoneySell
         // Tiền Bán Được = (số hàng đi - số hàng về) x dg;
         $('#TotalMoneySell').val((product_before - product_after) * default_prize + (product_before2 - product_after2) * default_prize2);

         //TotalMoneyBack
         // Tổng tiền về = Tiền gửi + (số hàng đi - số hàng về) x dg
         $('#TotalMoneyBack').val(addon_money + (product_before - product_after)*default_prize + (product_before2 - product_after2)*default_prize2);

         // TotalProductSell
         //Số đơn bán = Số hàng đi - số hàng về
         $('#TotalProductSell').val((product_before + product_before2) - (product_after + product_after2));
         window.scrollTo(0, document.body.scrollHeight);
   }

</script>

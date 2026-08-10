<?php
// $prize_default = 0;
$money_default = 0;
$prize_default1 = 0;
$prize_default2 = 0;
foreach($constant_list as $eachConstant){
  if($eachConstant['constant_name'] == 'prize'){
    $prize_default1 = $eachConstant['constant_value'];
  }
  if($eachConstant['constant_name'] == 'prize2'){
    $prize_default2 = $eachConstant['constant_value'];
  }
  if($eachConstant['constant_name'] == 'money_add_on'){
    $money_default = $eachConstant['constant_value'];
  }
}
//
//
// echo('<pre>');
// var_dump($constant_list);
// die;
 ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm transaction</h1>
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
                            Thêm transaction thành công
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
                              <select class="form-control" name="student_id">
                                <?php foreach ($student_list as $each_student): ?>
                                    <option value="<?php echo $each_student['id'] ?>"><?php echo $each_student['name'].'-'.$each_student['phone_number'] ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="addon_money">Tiền Gửi (tiền lẻ)</label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" name="addon_money" value="<?php echo $money_default ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn hàng giá <?php echo $prize_default1 ?></label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" name="count_product_before" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Số đơn hàng giá <?php echo $prize_default2 ?></label>
                                <input type="number" pattern="[0-9]*" inputmode="numeric" class="form-control" name="count_product_before2" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="count_product_before">Ghi Chú</label><br />
                                <textarea id="note" name="note" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

</div>
<script>
    $('select[name="role"]').change(function () {
        if ($(this).val() == 'admin') {
            $(".roles").hide();
        } else {
            $(".roles").show();
        }
    });
     $('select[name="role"]').change();
</script>

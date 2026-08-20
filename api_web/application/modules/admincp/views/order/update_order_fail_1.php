<div class="content-wrapper">    
    <section class="content-header">
        <h1>Cập nhật hoàn trả đơn hàng</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
            <li class="active">Cập nhật hoàn trả đơn hàng</li>
        </ol>
    </section>    
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">            
                <div class="col-md-12">   
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Alert!</h4>
                            <?php echo $count > 0 ? 'Cập nhật thành công ' . $count . ' đơn hàng bị hoàn trả ' : 'Không có đơn hàng nào thành công'; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo $msg; ?>                
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">                     
                        <div class="box-body col-md-4">
                            <div class="form-group">
                                <label for="title">Mã đơn hàng</label>
                                <textarea class="form-control" name="shipping_code"  style="height: 350px;"><?php echo @$_POST['shipping_code']; ?></textarea>
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
                                    <option  <?php echo @$_POST['shipping_type'] == 'f_shipping' ? 'selected' : ''; ?>  value="f_shipping">Giao hàng nhanh</option>
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
    </section>

</div>
<script>
    $("#form").validate({
        rules: {shipping_type: {required: true}}
    });
</script>
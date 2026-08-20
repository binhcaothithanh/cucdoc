
<div class="content-wrapper">    
    <section class="content-header">
        <h1>Cập nhật mã đi bưu điện</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
            <li class="active">Cập nhật mã đi bưu điện</li>
        </ol>
    </section>    
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">            
                <div class="col-md-12">   
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                            Thêm thành công
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
                        <div class="box-body col-md-4">
                            <div class="form-group">
                                <label for="alias">Mã của bưu điện</label>
                                <textarea name="office_code"  class="form-control" style="height: 350px;"><?php echo @$_POST['office_code']; ?></textarea>
                            </div>
                        </div> 
                    </div> 
                </div>
                <div  class="col-md-12">   
                    <div class="box box-primary box-success">                        
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>               
            </div>
        </form>
    </section>

</div>

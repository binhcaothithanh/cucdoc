<div class="content-wrapper">    
    <section class="content-header">
        <h1>Thêm loại thuộc tính</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>admin">Danh sách quản trị</a></li>            
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
                            Thêm  thành công
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
                                <label for="name">Tên loại thuộc tính</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="attribute">Thuộc tính</label>
                                <input type="text" class="form-control" name="attribute" placeholder="Cách nhau bởi dấu , ví dụ : Xanh,Đỏ,Tím">
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
    $("#form").validate({
        rules: {
            name: {required: true},
            attribute: {required: true}
        },
        messages: {
            'name': 'Vui lòng nhập loại thuộc tính',
            'attribute': 'Vui lòng nhập  thuộc tính',
        }
    });
</script>
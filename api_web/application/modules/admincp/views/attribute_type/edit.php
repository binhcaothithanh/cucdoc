<div class="content-wrapper">    
    <section class="content-header">
        <h1>Chỉnh sửa loại thuộc tính</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>admin">Danh sách loại thuộc tính</a></li>            
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
                            Cập nhật thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">                       
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Tên loại thuộc tính</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $attribute_type['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="attribute">Thuộc tính</label>
                                <input type="text" class="form-control" name="attribute" placeholder="Cách nhau bởi dấu , ví dụ : Xanh,Đỏ,Tím">
                            </div>
                            <table class="table table-bordered table-hover dataTable">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên thộc tính</th>
                                    <th>Action</th>
                                </tr>
                                <?php if ($attributes): ?>
                                    <?php $attributes = explode(',', $attributes); ?>
                                    <?php foreach ($attributes as $k => $v): ?>
                                        <tr>                                            
                                            <td><?php echo $k + 1; ?></td>
                                            <td><?php echo $v; ?></td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="del('<?php echo $v; ?>')">DELETE</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">Chưa có thuộc tính</td></tr>
                                <?php endif; ?>
                            </table>
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
            name: {required: true}
        },
        messages: {
            'name': 'Vui lòng nhập loại thuộc tính'
        }
    });
    var attr_type_id = <?php echo $attribute_type['id']; ?>;
    function del(attr) {
        show_dialog('Bạn có muốn thuộc tính thuộc tính ' + attr + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>attribute_type/del_attr', {attr: attr, attr_type_id: attr_type_id}, function (results) {                
                  location.reload();
            });
        });
    }
</script>
<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Danh sách loại thuộc tính</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
        </ol>      
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th>ID</th>
                                        <th>Tên</th>                                        
                                        <th>Actions</th>                                                
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td> 
                                            <td><?php echo $item['name']; ?></td>                                            
                                            <td>
                                                <a href="/<?php echo ADMIN_URL . 'attribute_type/edit/' . $item['id']; ?>">Edit</a>                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>      
                            </table>   
                            </table>
                        </div>
                    </div>                  
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section>
</div><!-- /.row -->

<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa loại thuộc tính id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>attribute_type/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

</script>

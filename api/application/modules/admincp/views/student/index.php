student<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST Student</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Student</li>
        </ol>
        <br/>
        <a href="/<?php echo ADMIN_URL; ?>student/add"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm Sinh Viên</button></a>
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
                                        <th>Fullname</th>
                                        <th>Actions</th>
                                        <th>Phone</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td style="font-Weight: bold; text-transform:uppercase"><?php echo $item['name']; ?><br />
                                              <!-- <?php // if($item['image_id'] != ''): ?>
                                                <image src="<?php // echo '/assets/upload/program/'. $item['image_id']; ?>" style="width: 200px" /><br />
                                              <?php // endif; ?> -->
                                              <?php if($item['photo'] != ''): ?>
                                              <image src="<?php echo '/assets/upload/program/'. $item['photo']; ?>" style="width: 100px" /><br />
                                              <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="/<?php echo ADMIN_URL . 'student/edit/' . $item['id']; ?>">Edit</a> |
                                                <a href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Delete</a>
                                            </td>
                                            <td><?php echo $item['phone_number']; ?></td>
                                            <td><?php echo $item['created_date']; ?></td>
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
        show_dialog('Bạn có muốn xóa Sinh Vien id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>student/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

</script>

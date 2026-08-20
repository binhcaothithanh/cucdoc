<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Danh Sach NV</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php  echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Danh Sach NV</li>
        </ol>
        <br/>
        <a href="/<?php  echo ADMIN_URL; ?>staff/add"><button style="width: 200px;" class="btn btn-block btn-primary">Them NV</button></a>
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
                                        <th>Tên NV</th>
                                        <th>SĐT</th>
                                        <th>Ghi Chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td>
                                              <a href="/<?php echo ADMIN_URL . 'staff/edit/' . $item['id']; ?>">
                                                <?php echo $item['username']; ?>
                                              </a>
                                            </td>
                                            <td><?php echo $item['phone_number']; ?></td>
                                            <td><?php echo $item['note']; ?></td>
                                            <td>
                                                <a href="/<?php echo ADMIN_URL . 'staff/edit/' . $item['id']; ?>">Edit</a> |
                                                <a href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Delete</a>
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
        show_dialog('Bạn có muốn xóa tài khoản id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>staff/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }

</script>

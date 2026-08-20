<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST program</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php  echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List program</li>
        </ol>
        <br/>
        <a href="/<?php  echo ADMIN_URL; ?>program/add"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm program</button></a>
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
                                        <th>program name</th>
                                        <th>image</th>
                                        <th>description</th>
                                        <th>Gender</th>
                                        <th>Goal</th>
                                        <th>Total week</th>
                                        <th>Retrieve</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td><?php echo $item['program_name']; ?></td>
                                            <td>
                                              <image style="width:100px" src="<?php echo PATH_PROGRAM_IMAGE . '/' . $item['image']; ?>" />
                                            </td>
                                            <td><?php echo $item['description']; ?></td>
                                            <td><?php echo $item['gender']; ?></td>
                                            <td><?php echo $item['goal']; ?></td>
                                            <td><?php echo $item['total_week']; ?></td>
                                            <td>
                                              <a href="/<?php echo ADMIN_URL . 'day/add?program_id=' . $item['id']; ?>">Add Ex details</a> |
                                                <a href="/<?php echo ADMIN_URL . 'program/edit/' . $item['id']; ?>">Edit</a> |
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
            $.post('/<?php echo ADMIN_URL; ?>program/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

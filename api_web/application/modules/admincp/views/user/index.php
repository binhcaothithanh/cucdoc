<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST user</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php  echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List user</li>
        </ol>
        <br/>
        <a href="/<?php  echo ADMIN_URL; ?>user/add"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm user</button></a>
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
                                        <th>User Name</th>
                                        <th>Age - Height - Weight</th>
                                        <th>Gender - Goal</th>
                                        <th>Money</th>
                                        <th>Note</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td>
                                              <?php echo $item['user_name']; ?><br />
                                              <?php // echo $item['image']; ?>
                                            </td>
                                            <td>
                                              <?php echo $item['age']; ?> - <?php echo $item['height']; ?> - <?php echo $item['weight']; ?>
                                            </td>
                                            <td>
                                              <?php echo $item['gender']; ?> - <?php echo $item['goal']; ?>
                                            </td>
                                            <td>
                                              <?php echo $item['money']; ?></td>

                                            <td>
                                              <?php echo $item['note']; ?></td>
                                            <td>
                                                <a href="/<?php echo ADMIN_URL . 'user/edit/' . $item['id']; ?>">Edit</a> |
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
        show_dialog('Bạn có muốn xóa user id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>user/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

</script>

<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST exercise</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php  echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List exercise</li>
        </ol>
        <br/>
        <a href="/<?php  echo ADMIN_URL; ?>exercise/add"><button style="width: 200px;" class="btn btn-block btn-primary">Add exercise</button></a>
        <br/>
        <a id="lnRefatorDesc" href="#"><button style="width: 200px;" class="btn btn-block btn-primary">Refactor Ex Desc</button></a>
        <input type="text" class="form-control" id="description" name="description" value="" />
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
                                        <th>image</th>
                                        <th>exercise name</th>
                                        <th>muscle</th>
                                        <th>difficulty</th>
                                        <th>equipment</th>
                                        <th>description</th>
                                        <th>Retrieve</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td>
                                              <img src='<?php echo PATH_EXERCISE_IMAGE . $item['image']; ?>' style='height: 100px' />
                                            </td>
                                            <td>
                                              <a href="/<?php echo ADMIN_URL . 'exercise/edit/' . $item['id']; ?>">
                                                <?php echo $item['exercise_name']; ?>
                                              </a>
                                            </td>
                                            <td><?php echo $item['muscle']; ?></td>
                                            <td><?php echo $item['difficulty']; ?></td>
                                            <td><?php echo $item['equipment']; ?></td>
                                            <td><?php echo (substr($item['description'],0,100).'...'); ?></td>
                                            <td>
                                                <a href="/<?php echo ADMIN_URL . 'exercise/edit/' . $item['id']; ?>">Edit</a> |
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
            $.post('/<?php echo ADMIN_URL; ?>exercise/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }


    $('#lnRefatorDesc').click(function () {

      var numberProgram = 0;

      $('#description').val('getting value.....');

        $.post('/<?php  echo ADMIN_URL; ?>Exercise/RefactorExerciseDescAjax', {numberProgram: numberProgram}, function (result) {
          $('#description').val(result);
        });
    });
</script>

</script>

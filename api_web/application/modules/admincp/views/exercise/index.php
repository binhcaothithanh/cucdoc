<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST timesheet</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php  echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List timesheet</li>
        </ol>
        <br/>
        <a href="/<?php  echo ADMIN_URL; ?>timesheet/add"><button style="width: 200px;" class="btn btn-block btn-primary">Add timesheet</button></a>
        
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
                                        <th>image</th>
                                        <th>timesheet name</th>
                                        <th>muscle</th>
                                        <th>difficulty</th>
                                        <th>equipment</th>
                                        <th>description</th>
                                        <th>Retrieve</th>
                                    </tr>
                                </thead>
                                
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
            $.post('/<?php echo ADMIN_URL; ?>timesheet/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }


    $('#lnRefatorDesc').click(function () {

      var numberProgram = 0;

      $('#description').val('getting value.....');

        $.post('/<?php  echo ADMIN_URL; ?>Timesheet/RefactorTimesheetDescAjax', {numberProgram: numberProgram}, function (result) {
          $('#description').val(result);
        });
    });
</script>

</script>

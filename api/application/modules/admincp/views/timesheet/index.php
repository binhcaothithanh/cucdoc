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
        <br />
        Từ
        <input id="fromTime" name="fromTime" type="date" />
        đến
        <input id="toTime" name="toTime" type="date" />
        <br /><br />
        <a style="width: 200px;" href="#" id="search" name="search" class="btn btn-block btn-primary">Tìm kiếm</a><br />
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div id="list_ajax" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- ajax content -->
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section>
</div><!-- /.row -->

<script>
function loadlist() {
  // current_pos = pos;
  var fromTime = $('#fromTime').val();
  var toTime = $('#toTime').val();
  $.post('/<?php echo ADMIN_URL; ?>Timesheet/ajaxFilterTime', {fromTime: fromTime, toTime: toTime}, function (result) {
    // alert(result);
    $('#list_ajax').html(result);
        });
  }
  
  window.onload = function() {
    var now = new Date();
    var day = ("01");
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var fromTime = now.getFullYear()+"-"+(month)+"-"+(day);
    var toDay = now.getFullYear()+"-"+(month)+"-"+(("0" + now.getDate()).slice(-2));
    $('#fromTime').val(fromTime);
    $("#toTime").val(toDay);
    loadlist();
  }
//
//   function leaveChange(control) {
//     loadlist();
// }


  $('#search').click(function () {
    loadlist();
  })
  </script>

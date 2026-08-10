<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Danh sách dự án</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Danh sách dự án</li>
        </ol>


        <div class="row">
            <div class="col-md-6">
              <div class="box box-primary box-success">
                <div class="box-body">
                    <div class="form-group">
                    <p>
                      <label>Tên dự án</label>
                      <input type="text" name="projectName" id="projectName" class="form-control" /> <br />
                      Từ
                      <input id="fromTime" name="fromTime" type="date" />
                      đến
                      <input id="toTime" name="toTime" type="date" />
                    </p>
                      <br />
                      <a style="width: 200px;" href="#" id="search" name="search" class="btn btn-block btn-primary">Tìm kiếm</a><br />
                      <a style="width: 200px;" href="/<?php echo ADMIN_URL; ?>project/add"class="btn btn-block btn-primary">Thêm Dự Án</a>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>


  <div id="list_ajax"></div><!-- /.col -->

</div><!-- /.row -->

<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa tài khoản id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>/project/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

<script>
function loadlist() {
  // current_pos = pos;
  var projectName = $('#projectName').val();
  var fromTime = $('#fromTime').val();
  var toTime = $('#toTime').val();
  var projectName = $("#projectName").val();
  var user_role = "<?php echo($user['role']); ?>";
  $.post('/<?php echo ADMIN_URL; ?>project/page', {user_role: user_role,fromTime: fromTime, toTime: toTime, projectName: projectName}, function (result) {
    $('#list_ajax').html(result);
        });
  }
  // $.post('/<?php echo ADMIN_URL; ?>project/page', {status: status, phone: phone, shipping_type: shipping_type}, function (result) {
  //   $('#list_ajax').html(result);
  //       });
  // }
  window.onload = function() {
    var now = new Date();
    // var fromTime = now.getFullYear() + '/01/01';
    var fromTime = '2022/01/01';
    // alert($("#fromTime").val());
    $("#fromTime").val('2022-01-01');
    $("#toTime").val(now.getFullYear() + '-' + (now.getMonth() +1) + '-' + now.getDate());
    loadlist();
  }

  $('#search').click(function () {
    loadlist();
  })
  </script>

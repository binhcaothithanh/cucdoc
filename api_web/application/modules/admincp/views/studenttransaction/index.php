<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST Transaction</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Transaction</li>
        </ol>
        <br/>
        <a href="/<?php echo ADMIN_URL; ?>StudentTransaction/add"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm Transaction</button></a>
        <br />
        <div class="box box-primary box-success">
            <div class="box-body">
                <div class="form-group">

                  <select class="form-control" id="student_id" name="student_id"  >
                        <option  value=''>-Tất Cả Sinh Viên-</option>
                    <?php foreach ($student_list as $each_student): ?>
                        <option value="<?php echo $each_student['id'] ?>"><?php echo $each_student['name'].'-'.$each_student['phone_number'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <input type="hidden" id="studentName" name="studentName" value="">
                  Từ
                  <input id="fromTime" name="fromTime" type="date" />
                  đến
                  <input id="toTime" name="toTime" type="date" />
                  <a style="width: 200px;" href="#" id="search" name="search" class="btn btn-block btn-primary">Tìm kiếm</a><br />

                </div>
              </div>
            </div>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                          <div id="list_ajax"></div>


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
  var student_id = $('#student_id').val();
  if(student_id == "" || student_id == "0"){
    student_id = null;
  }
  var fromTime = $('#fromTime').val();
  var toTime = $('#toTime').val();
  var student_name = $('#studentName').val();
  var user_role = "<?php echo($user['role']); ?>";
  $.post('/<?php echo ADMIN_URL; ?>StudentTransaction/load', {user_role: user_role,fromTime: fromTime, toTime: toTime, student_id: student_id, student_name: student_name}, function (result) {
    // alert(result);
    $('#list_ajax').html(result);
        });
  }
  // $.post('/<?php echo ADMIN_URL; ?>project/page', {status: status, phone: phone, shipping_type: shipping_type}, function (result) {
  //   $('#list_ajax').html(result);
  //       });
  // }
  window.onload = function() {
    // var now = new Date();
    // var fromTime = Date.parse(now.getFullYear() + now.getMonth());
    // // var fromTime = '2022/01/01';
    // // alert($("#fromTime").val());
    // $("#fromTime").val(fromTime);
    // $("#toTime").val(now.getFullYear() + '-' + (now.getMonth() +1) + '-' + now.getDate());

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


  $('#student_id').on('change', function() {
    // alert(this.options[this.selectedIndex].text);
    $('#studentName').val(this.options[this.selectedIndex].text);
});

  $('#search').click(function () {
    loadlist();
  })
  </script>

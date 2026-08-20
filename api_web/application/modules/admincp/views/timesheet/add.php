
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm Timesheet</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>timesheet">Danh sách timesheet</a></li>
        </ol>
    </section>
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data" >
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0) : ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4> <i class="icon fa fa-check"></i> Alert!</h4>
                            Thêm timesheet thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1) : ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo @$msg; ?>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="user_id">NV</label>
                                <select id="user_id" name="user_id" class="form-control" required>
                                    <option value=""> --- DS NV --- </option>
                                    <?php
                                    foreach ($list_staff as $staff) : ?>
                                        <option value="<?php echo ($staff['id']) ?>"><?php echo ($staff['username']) ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                              <input type="checkbox" id="full_month" name="full_month" >
                                <label for="full_month">Full month work? </label>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="created_date">For Date</label>
                                <?php
                                $now = date_default_timezone_set('Asia/Colombo'); // Set Time-Zone
                                $now = date('d-m-Y'); //Fomat Date and time
                                ?>
                                <input required type="text" name="created_date" value="<?php echo $now; ?>" class="form-control" placeholder="created date">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="in_time">In Time</label>
                                <input type="time" id="in_time" name="in_time" required class="form-control" placeholder="in time 6:00">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="out_time">Out Time</label>
                                <input type="time" id="out_time" name="out_time" required class="form-control" placeholder="out time 13:30">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="salary_used">Salary used</label>
                                <input id="salary_used" name="salary_used" value="0" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

</div>
<script>
      // jQuery to disable/enable controls based on the checkbox status
      $(document).ready(function() {
          $('#full_month').change(function() {
              if($(this).is(':checked')) {
                  $('#salary_used').prop('disabled', true);

              } else {
                  $('#salary_used').prop('disabled', false);
              }
          });
      });
  </script>

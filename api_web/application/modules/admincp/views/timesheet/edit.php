<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT Exercise</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>exercise">List exercise</a></li>
            <li class="active">Edit exercise</li>
        </ol>
    </section>
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0) : ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4> <i class="icon fa fa-check"></i> Alert!</h4>
                            cap nhat thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1) : ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                    <div class="box-body">
                            <div class="form-group">
                                <label for="username">NV</label>
                                <input type="text" name="username" disabled value="<?php echo ($staff['username']) ?>" class="form-control" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="in_time">In Time</label>
                                <input type="time" name="in_time" required class="form-control" value="<?php echo $timesheet['in_time'];  ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="out_time">Out Time</label>
                                <input type="time" name="out_time" required class="form-control" placeholder="out time 13:30" value="<?php echo $timesheet['out_time'];  ?>" >
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="created_date">For Date</label>
                                <?php
                                $now = date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set Time-Zone
                                $now = date($timesheet['created_date']); //Fomat Date and time
                                ?>
                                <input type="text" name="created_date" value="<?php echo $now; ?>" class="form-control" placeholder="created date">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="salary_used">Salary used</label>
                                <input name="salary_used" class="form-control" value="<?php echo $timesheet['salary_used'];  ?>" >
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

</div>

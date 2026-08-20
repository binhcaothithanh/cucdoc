<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm user</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL ; ?>user">Danh sách user</a></li>
        </ol>
    </section>
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                            Thêm user thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
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
                                <label for="user_name">User name</label>
                                <input type="text" class="form-control" name="user_name" placeholder="Enter user name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" name="age" placeholder="Enter age">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-group" name="gender">
                                  <option>male</option>
                                  <option>female</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="weight">Money</label>
                                <input type="text" class="form-control" name="money" placeholder="Enter money (for testing)">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" >
                      <div class="box box-primary box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="height">Height</label>
                                <input type="text" class="form-control" name="height" placeholder="height (Cm)">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="text" class="form-control" name="weight" placeholder="Enter weight (Kg)">
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="goal">Goal</label>
                                <select name="goal" class="form-group">
                                  <option value="Fat Loss">Fat Loss</option>
                                  <option value="Maintenance">Maintenance</option>
                                  <option value="Muscle Gain">Muscle Gain</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="calorie">Daily Calorie Need(Cal)</label>
                                <input type="text" class="form-control" name="calorie" placeholder="Enter calorie">
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

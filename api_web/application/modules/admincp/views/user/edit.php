<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT user</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>user">List user</a></li>
            <li class="active">Edit user</li>
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
                            cap nhat thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-header">
                            <h3 class="box-title">Basic info</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="user_name">User name</label>
                                <input type="text" class="form-control" name="user_name"  value="<?php echo $userItem['user_name']; ?>">
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
                                <input type="text" class="form-control" name="age"  value="<?php echo $userItem['age']; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-group" name="gender">
                                  <option <?php if($userItem['gender'] == "male"):
                                    echo 'selected';
                                  endif; ?> >male</option>
                                  <option <?php if($userItem['gender'] == "female"):
                                    echo 'selected';
                                  endif; ?>>female</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="weight">Money</label>
                                <input type="text" class="form-control" name="money"  value="<?php echo $userItem['money']; ?>">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" >
                      <div class="box box-primary box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="height">Height</label>
                                <input type="text" class="form-control" name="height"  value="<?php echo $userItem['height']; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="text" class="form-control" name="weight"  value="<?php echo $userItem['weight']; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="goal">Goal</label>
                                <select name="goal" class="form-group">
                                  <option <?php if($userItem['goal'] == "Fat Loss"):
                                      echo 'selected';
                                    endif; ?> value="Fat Loss">Fat Loss</option>
                                  <option <?php if($userItem['goal'] == "Maintenance"):
                                    echo 'selected';
                                  endif; ?> value="Maintenance">Maintenance</option>
                                  <option <?php if($userItem['goal'] == "Muscle Gain"):
                                    echo 'selected';
                                  endif; ?> value="Muscle Gain">Muscle Gain</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="calorie">Daily Calorie Need(Cal)</label>
                                <input type="text" class="form-control" name="calorie"  value="<?php echo $userItem['calorie']; ?>">
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

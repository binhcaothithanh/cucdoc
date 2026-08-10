<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm program</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>program">Danh sách program</a></li>
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
                            add program success
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
                                <label for="image">image program</label>
                                <p>
                                <label for="image">Hình từ file(300x400)</label>
                                <input id="photo" name="photo"  type="file" accept="image/*" /><br/>
                                </p>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <br />
                                <textarea name="description" class="form-control" rows="13" id="description"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" >
                  <div class="box box-primary box-success">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="program_name">program name</label>
                            <input type="text" class="form-control" name="program_name" placeholder="Enter program name">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="program_name">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                              <option selected value="Male & Female">Male & Female</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                          </select>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="goal">Goal</label>
                            <select class="form-control" id="goal" name="goal">
                              <option value="lose fat">Lose Fat</option>
                              <option value="build muscle">Build Muscle</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="total_week">Total week</label>
                            <select class="form-control" id="total_week" name="total_week" onChange="setDay(this)">
                              <option selected value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="description">Creator id</label>
                            <br />
                            <input type="text" class="form-control" id="creator_id" name="creator_id" value="0" placeholder="Enter creator id (default admin 0)">
                            <br />
                            <select id="user_list" name="user_list" class="form-control" onChange="setUserId(this)">
                                <option value="0"> --- User list --- </option>
                                <option value="0"> admin </option>
                                <?php
                                foreach ($users as $user) : ?>
                                    <option value="<?php echo ($user['id']) ?>"> <?php echo ($user['id'] . '   -   ' . $user['user_name']) ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="box-body" id="listday">
                    </div>
                  </div>
                </div>
            </div>
        </form>
    </section>

</div>
<script type="text/javascript">

function setUserId(sel) {
        var userId = $("#user_list option:selected").attr('value');
        // alert(userId);
         document.getElementById("creator_id").value = userId;
};

    function setDay(sel) {
      // var html = "<>";
      // $("#listday").append(html);
    };
</script>

<div class="content-wrapper">    
    <section class="content-header">
        <h1>EDIT Admin</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>admin">List Admin</a></li>
            <li class="active">Edit Admin</li>
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
                                <label for="username">Username</label>
                                <input type="text" value="<?php echo $admin['username']; ?>" class="form-control" disabled="" placeholder="Enter username">
                            </div>
                        </div>  
                        <div class="box-body">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select  class="form-control" name="role">                                                                        
                                    <option  <?php echo $admin['role'] == 'manager' ? 'selected' : ''; ?> value="manager">Manager</option>
                                    <option  <?php echo $admin['role'] == 'partner' ? 'selected' : ''; ?> value="partner">Partner</option>                                    
                                    <option <?php echo $admin['role'] == 'admin' ? 'selected' : ''; ?> value="admin">Admin</option>
                                </select>
                            </div>
                        </div> 
                        <div class="box-body roles">
                            <div class="form-group">
                                <label for="roles">Roles</label><br/>
                                <div style="clear: both;"></div>
                                <?php foreach ($role_details as $k => $v): ?>
                                    <div class="checkbox" style="width: 150px;float: left;margin-top: 5px">
                                        <label>
                                            <input <?php echo strpos($admin['roles'], $k) !== false ? 'checked' : ''; ?> type="checkbox" name="roles[]" value="<?php echo $k ?>"/> <?php echo $v; ?> 
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>   
                        <div class="box-body">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password"  class="form-control" name="password" placeholder="Enter password">
                            </div>
                        </div>      
                        <div class="box-body">
                            <div class="form-group">
                                <label for="repassword">Re-password</label>
                                <input type="password"  class="form-control" name="repassword" placeholder="Enter re-password">
                            </div>
                        </div>      
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" class="form-control" name="fullname" value="<?php echo $admin['fullname']; ?>"/>
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
<script>
    $('select[name="role"]').change(function () {
        if ($(this).val() == 'admin') {
            $(".roles").hide();
        } else {
            $(".roles").show();
        }
    });
    $('select[name="role"]').change();
</script>
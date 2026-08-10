<div class="content-wrapper">
    <section class="content-header">
        <h1>Sửa mật khẩu quản tri</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
                            Đổi Password thành công
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
                                <label for="username">Username (Cant change)</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $user['username'] ?>" disabled placeholder="Enter username">
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
                                <input type="text" class="form-control" name="fullname" value="<?php echo $user['fullname']; ?>" placeholder="Enter fullname">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                            <a class="btn btn-primary" href="/<?php echo ADMIN_URL; ?>"> Cancel </a>
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

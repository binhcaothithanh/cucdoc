<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm Constant</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>StudentConstant">Danh sách Constant</a></li>
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
                            Thêm Constant thành công
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
                                <label for="username"> Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Full Name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="phone_number">Value</label>
                                <input  type="text" class="form-control" name="value" placeholder="Enter value">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" class="form-control" name="note" placeholder="Enter note">
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
    // $('select[name="role"]').change(function () {
    //     if ($(this).val() == 'student') {
    //         $(".roles").hide();
    //     } else {
    //         $(".roles").show();
    //     }
    // });
    //  $('select[name="role"]').change();
</script>

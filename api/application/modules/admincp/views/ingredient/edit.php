<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT Staff</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>staff">Danh Sach NV</a></li>
            <li class="active">Edit NV</li>
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
                        <div class="box-header">
                            <h3 class="box-title">Basic info</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nausernameme">Ten NV</label>
                                <input type="text" name="username" value="<?php echo $staff['username']; ?>" class="form-control" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">phone number</label>
                                <input type="text" name="phone_number" value="<?php echo $staff['phone_number']; ?>" class="form-control" placeholder="Enter phone_number">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">note</label>
                                <textarea name="note" class="form-control" id="note"><?php echo $staff['note']; ?></textarea>
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

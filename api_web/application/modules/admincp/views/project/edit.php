<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT Project</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>/project">List Project</a></li>
            <li class="active">Sửa Dự Án</li>
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
                            <h3 class="box-title">Thông tin cơ bản</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="project_name">Tên dự án</label>
                                <input name="project_name" type="text" value="<?php echo $project['project_name']; ?>" class="form-control" placeholder="nhập tên dự án">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="type">Sản phẩm ? Tiền ?</label>
                                <select class="form-control" name="type">
                                  <option  <?php echo $project['type'] == 'product' ? 'selected' : ''; ?> value="product">SL sản phẩm</option>
                                  <option  <?php echo $project['type'] == 'money' ? 'selected' : ''; ?> value="money">tiền</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="role">Trạng thái</label>
                                <select  class="form-control" name="status">
                                    <option  <?php echo $project['status'] == 'open' ? 'selected' : ''; ?> value="open">Mở</option>
                                    <option  <?php echo $project['status'] == 'close' ? 'selected' : ''; ?> value="close">Đóng</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Nội Dung</label>
                                <textarea name="note" class="form-control" cols="40" rows="5"><?php echo $project['note']; ?></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <a href="/<?php echo ADMIN_URL; ?>project" style="margin-left:20" class="btn btn-primary">Back</a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
</div>

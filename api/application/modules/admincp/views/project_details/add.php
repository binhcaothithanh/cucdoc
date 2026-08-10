<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm tài chính</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>projectdetails?project_id=<?php echo($project['id']); ?>">Danh sách tài chính cho dự án</a></li>
            <li class="active">Thêm tài chính cho dự án</li>
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
                            Thêm tài chính
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
                                <label for="project_name">Tên dự án</label>
                                <input type="text" class="form-control" name="project_name" disabled value="<?php echo($project['project_name']) ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select class="form-control" name="status" disabled>
                                    <option <?php echo $type == 'pay' ? 'selected' : ''; ?>  value="pay">Chi tiền</option>
                                    <option <?php echo $type == 'receive' ? 'selected' : ''; ?> value="receive">Thu tiền</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Số tiền</label>
                                <input type="text" class="form-control" name="money" placeholder="Số tiền">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Nội dung tiền</label>
                                <textarea name="content" class="form-control" cols="40" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="photo">hình ảnh liên quan</label>
                                <p>
                                <label for="image"> file hình</label>
                                <input id="photo" name="photo"  type="file" accept="image/*" /><br/>
                                </p>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">người tạo</label>
                                <input type="text" class="form-control" name="created_user" value="<?php echo  $username; ?>">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <a href="/<?php echo ADMIN_URL; ?>projectdetails?project_id=<?php echo($project['id']); ?>" class="btn btn-primary">Back</a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
</div>

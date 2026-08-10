<div class="content-wrapper">
    <section class="content-header">
        <h1>Chỉnh sửa tài chính</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>projectdetails?project_id=<?php echo($projectdetails['project_id']); ?>">Dự Án</a></li>
            <li class="active">Sửa tài chính</li>
        </ol>
    </section>
    <section class="content">
        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-5">
                    <?php if ($check_error == 0): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>	<i class="icon fa fa-check"></i> Alert!</h4>
                            Sửa thông tin tài chính
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
                                <label for="status">Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option <?php echo $projectdetails['status'] == 'pay' ? 'selected' : ''; ?>  value="pay">Chi tiền</option>
                                    <option <?php echo $projectdetails['status'] == 'receive' ? 'selected' : ''; ?> value="receive">Thu tiền</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Số tiền</label>
                                <input type="text" class="form-control" name="money" placeholder="Số tiền" value="<?php echo $projectdetails['money'] ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Nội dung tiền</label>
                                <textarea name="content" class="form-control" cols="40" rows="5"><?php echo $projectdetails['content'] ?></textarea>

                            </div>
                        </div>
                        <?php if($projectdetails['data_file'] != ''): ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="photo">hình ảnh liên quan</label>
                                <p>
                                  <image src="<?php echo '/assets/upload/'. $projectdetails['data_file']; ?>" style="width: 500px" />
                                <label for="image"> file hình</label>
                                <input id="photo" name="photo"  type="file" accept="image/*" /><br/>
                                </p>
                            </div>
                        </div>
                      <?php endif; ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">người tạo</label>
                                <input type="text" class="form-control" name="created_user" disabled value="<?php echo $projectdetails['created_user'] ; ?>" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="note">Ngày tạo:</label>
                                <input type="text" class="form-control" name="created_user" disabled value="<?php echo date("d/m/Y", strtotime($projectdetails['created_date'])) ; ?>" />
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                            <a href="/<?php echo ADMIN_URL; ?>projectdetails?project_id=<?php echo($projectdetails['project_id']); ?>" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
                <?php if($projectdetails['status'] == 'pay'): ?>
                <div class="col-md-5">
                  <div class="box box-primary box-success">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="status">quản trị trả tiền</label>
                            <select class="form-control" name="approved">
                                <option <?php echo $projectdetails['approved'] == '0' ? 'selected' : ''; ?>  value="0">Chưa trả</option>
                                <option <?php echo $projectdetails['approved'] == '1' ? 'selected' : ''; ?> value="1">đã trả</option>
                            </select>
                        </div>
                    </div>
                    <?php if($projectdetails['approve_image'] != ''): ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="photo_approve">image approve?</label>
                            <p>
                              <image src="<?php echo '/assets/upload/'. $projectdetails['approve_image']; ?>" style="width: 200px" />
                            <label for="photo_approve"> file hình</label>
                            <input id="photo_approve" name="photo_approve"  type="file" accept="image/*" /><br/>
                            </p>
                        </div>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
        </form>
    </section>
</div>

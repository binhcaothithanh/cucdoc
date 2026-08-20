<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm dự án</h1>
        <ol class="breadcrumb">
          <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="/<?php echo ADMIN_URL; ?>/project">List Project</a></li>
          <li class="active">Thêm Dự Án</li>
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
                            Thêm dự án thành công
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
                              <label for="money">Tên dự án</label>
                              <input type="text" class="form-control" name="project_name" placeholder="Tên dự án">
                          </div>
                      </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="project_name">Nội dung giao dịch </label>
                                <textarea name="note" class="form-control" cols="40" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status">Trạng thái dự án</label>
                                <select class="form-control" name="status">
                                    <option value="open">mới</option>
                                    <option value="close">kêt thúc</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status">Sản phẩm ? Tiền ?</label>
                                <select class="form-control" name="type">
                                    <option value="product">SL sản phẩm</option>
                                    <option value="money">tiền</option>
                                </select>
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
<script>
    $('select[name="role"]').change(function () {
        if ($(this).val() == 'Project') {
            $(".roles").hide();
        } else {
            $(".roles").show();
        }
    });
     $('select[name="role"]').change();
</script>

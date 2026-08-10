<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm eBook</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL ; ?>Ebook">Danh sách eBook</a></li>
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
                            Thêm eBook thành công
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
                                <label for="page_content_vn">eBook content VN</label>
                                <input type="text" class="form-control" id="page_content_vn" name="page_content_vn" placeholder="Enter eBook name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="page_content_en">eBook content EN</label>
                                <input type="text" class="form-control" name="page_content_en" placeholder="Enter eBook name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="advise_type">advise type</label>
                                <select class="form-control" id="advise_type" name="advise_type">
                                  <option value="yes">yes</option>
                                  <option value="no">no</option>
                                  <option value="null">null</option>
                                  <option value="advise">advise</option>
                              </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="page_type">page type</label>
                                <input type="text" class="form-control" name="page_type" value="page">
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
$(function() {
$("#page_content_vn").focus();
});
</script>

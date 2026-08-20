<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm Ebook</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL ; ?>Ebook">Danh sách Ebook A</a></li>
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
                            Thêm Ebook thành công
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
                                <label for="difficulty_name">Ebook content VN</label>
                                <input type="text" class="form-control" name="difficulty_name" placeholder="Enter Ebook name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="difficulty_name">Ebook content EN</label>
                                <input type="text" class="form-control" name="page_content_vn" placeholder="Enter Ebook name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="difficulty_name">page type</label>
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

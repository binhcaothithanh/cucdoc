<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT PAGE</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>page">List page</a></li>
            <li class="active">Edit Page</li>
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
                            Sửa thành công
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
                                <label for="title">Title</label>
                                <input type="text" value="<?php echo $page['title']; ?>" class="form-control" id="title" onblur="taolink('title', 'alias')" onkeyup="taolink('title', 'alias')" name="title" placeholder="Enter Title">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="alias">Alias</label>
                                <input type="text" value="<?php echo $page['alias']; ?>"class="form-control" id="alias" name="alias" placeholder="Enter Alias">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // echo('<pre>');
                // var_dump($page);
                // die;

                ?>
                <div  class="col-md-12">
                    <div style="padding: 15px;" class="box box-primary box-success">
                        <div class="box-header">
                            <h3 class="box-title">Content</h3>
                        </div>
                        <textarea id="textarea_content" name="content" style="width: 100%; height: 200px"><?php echo $page['content']; ?></textarea>
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
    CKEDITOR.config.entities_latin = false;
    var editor2 = CKEDITOR.replace('textarea_content');
    CKFinder.setupCKEditor(editor2, '/assets/admin/ckfinder/');
</script>

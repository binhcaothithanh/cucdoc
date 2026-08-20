<div class="content-wrapper">    
    <section class="content-header">
        <h1>SEO HOME</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>SEO HOME</li>            
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
                            Cập nhật thành công
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
                                <label for="seo_title">Seo title</label>
                                <input type="text" class="form-control" value="<?php echo @$result['seo_title']; ?>" name="seo_title">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta description</label>
                                <input type="text" class="form-control" value="<?php echo @$result['meta_description']; ?>" name="meta_description">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Meta keyword</label>
                                <input type="text" class="form-control" value="<?php echo @$result['meta_keyword']; ?>" name="meta_keyword">
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

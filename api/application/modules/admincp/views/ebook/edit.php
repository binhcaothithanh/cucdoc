<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT eBook</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>Ebook">List eBook</a></li>
            <li class="active">Edit eBook</li>
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
                        <div class="box-body">
                            <div class="form-group">
                                <label for="page_content_vn">Ebook content VN</label>
                                <input type="text" class="form-control" name="page_content_vn" value="<?php echo($ebook['page_content_vn']); ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="page_content_en">Ebook content EN</label>
                                <input type="text" class="form-control" name="page_content_en" value="<?php echo($ebook['page_content_en']); ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="advise_type">advise type</label>
                                <select class="form-control" id="advise_type" name="advise_type">
                                  <option
                                  <?php if($ebook['advise_type'] === 'yes'):
                                    echo(' selected ');
                                  endif; ?>
                                     value="yes">yes</option>
                                  <option
                                  <?php if($ebook['advise_type'] == 'no'):
                                    echo(' selected ');
                                  endif; ?>
                                     value="no">no</option>
                                  <option
                                  <?php if($ebook['advise_type'] == 'null'):
                                    echo(' selected ');
                                  endif; ?>
                                   value="null">null</option>
                                   <option
                                   <?php if($ebook['advise_type'] == 'advise'):
                                     echo(' selected ');
                                   endif; ?>
                                    value="advise">advise</option>
                              </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="page_type">page type</label>
                                <input type="text" class="form-control" name="page_type" value="<?php echo($ebook['page_type']); ?>">
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

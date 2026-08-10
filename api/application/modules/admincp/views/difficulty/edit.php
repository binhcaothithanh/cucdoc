<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT difficulty</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>difficulty">List difficulty</a></li>
            <li class="active">Edit difficulty</li>
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
                            <h3 class="box-title">Basic info</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">difficulty name</label>
                                <input type="text" name="difficulty_name" value="<?php echo $difficulty['difficulty_name']; ?>" class="form-control" placeholder="Enter username">
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <label for="fullname">image name</label>
                                <input type="text" class="form-control" name="image" value="<?php echo $difficulty['image']; ?>"/>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fullname">Description</label>
                                <input type="text" class="form-control" name="description" value="<?php echo $difficulty['description']; ?>"/>
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

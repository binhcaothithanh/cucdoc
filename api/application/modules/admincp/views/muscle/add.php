<div class="content-wrapper">    
    <section class="content-header">
        <h1>Thêm muscle</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL ; ?>muscle">Danh sách muscle</a></li>            
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
                            Thêm muscle thành công
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
                                <label for="muscle_name">muscle name</label>
                                <input type="text" class="form-control" name="muscle_name" placeholder="Enter muscle name">
                            </div>
                        </div>      
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image">image name</label>
                                <input type="text" class="form-control" name="image" placeholder="Enter muscle image">
                            </div>
                        </div>      
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Enter description">
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
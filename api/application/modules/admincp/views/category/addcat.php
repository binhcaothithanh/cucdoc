<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm thể loại</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>admin">Danh sách quản trị</a></li>
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
                            Thêm  thành công
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
                              <label for="catid">id cat parent</label>
                              <input type="text" class="form-control" name="catid">

                                <label for="link">link thể loại</label>
                                <input type="text" class="form-control" name="link">
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
    $("#form").validate({
        rules: {
            name: {required: true},
            attribute: {required: true}
        },
        messages: {
            'name': 'Vui lòng nhập thể loại',
            'attribute': 'Vui lòng nhập  thuộc tính',
        }
    });
</script>
<style>
    div.checkbox{width: 33%;float: left;margin-top: 0px;}
    .checkbox+.checkbox, .radio+.radio{     margin-top: 0px;}
</style>

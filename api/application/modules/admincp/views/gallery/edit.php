<div class="content-wrapper">    
    <section class="content-header">
        <h1>EDIT GALLERY</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>gallery">List galllery</a></li>
            <li class="active">EDIT GALLERY</li>
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
                            cập nhật thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo @$msg; ?>                          
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">                       
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control" value="<?php echo $gallery['title']; ?>" name="title" placeholder="nhập tiêu đề">
                            </div>
                            <div class="form-group">
                                <label for="type">Loại</label>
                                <select class="form-control" name="type">
                                    <option value="slider">Slider</option>
                                    <option <?php echo $gallery['type'] == 'banner' ? 'selected' : ''; ?> value="banner">Banner</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <input type="text" class="form-control" value="<?php echo $gallery['description']; ?>"   name="description" placeholder="nhập mô tả">
                            </div>
                            <div class="form-group">
                                <label for="title">Link</label>
                                <input type="text" class="form-control"  name="link" value="#">

                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh (<label class="label_slider label_gallery">700 x 320</label><label class="label_banner label_gallery" style="display: none;">240 x 100</label>)</label>
                                <input type="file" class="form-control"  name="image" >
                                <br/>
                                <img src="/assets/upload/gallery/<?php echo $gallery['image']; ?>" width="200px"/>
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
    $("select[name='type']").change(function () {
        var val = $(this).val();
        $('.label_gallery').hide();
        $('.label_' + val).show();
    });
    $("select[name='type']").change();
</script>
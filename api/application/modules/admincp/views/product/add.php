<div class="content-wrapper">    
    <section class="content-header">
        <h1>Thêm sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>product">Danh sách sản phẩm</a></li>            
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
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="title">
                            </div>                           
                            <div class="form-group">
                                <label for="cat_id">Loại sản phẩm</label>
                                <select name="cat_id" class="form-control">                                    
                                    <?php echo $category_html; ?>
                                </select>
                            </div>  
                            <div class="form-group">
                                <label for="cogs">Giá vốn</label>
                                <input type="text" class="form-control format_number" name="cogs">
                            </div> 
                            <div class="form-group">
                                <label for="price">Giá bán</label>
                                <input type="text" class="form-control format_number" name="price">
                            </div> 
                            <div class="form-group">
                                <label for="price_compare">Giá so sánh</label>
                                <input type="text" class="form-control format_number" name="price_compare">
                            </div> 
                            <p>
                                <label for="image">Hình từ file(300x400)</label>                    
                                <input id="photo" name="photo"  type="file" accept="image/*" /><br/>                    
                            </p>

                            <br/><br/>
                            <fieldset>
                                <legend>Danh sách hình trong album</legend>
                                <input type="file" accept="image/*" id="images" name="images[]" multiple />
                                <div id="image" class="image_product_details"></div>
                                <input type="hidden" value="" name="order_image" />
                            </fieldset>
                            <br/><br/> <br/><br/>
                        </div>                            

                    </div>    

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="box box-primary box-success">                       
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="can_buy">Được bán khi hết hàng</label>                                    
                                    <select class="form-control" name="can_buy">
                                        <option value="0">No</option>
                                        <option value="1">YES</option>                                        
                                    </select>

                                </div>                                  
                                <div class="form-group">
                                    <label for="product_status">Trạng thái</label>
                                    <select class="form-control" name="product_status">
                                        <option value="0">Bình thường</option>
                                        <option value="1">Bán chạy</option>
                                        <option value="2">Sẩn phẩm mới</option>
                                    </select>

                                </div>  
                                <br/>
                                <div class="form-group">
                                    <label for="color">Màu sắc</label>
                                    <div style="clear: both;">
                                        <?php
                                        $color = $attribute_types[0]['attr'];
                                        if ($color)
                                            $color = explode(',', $color);
                                        ?>
                                        <?php foreach ($color as $item): ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="attr_color" value="<?php echo $item; ?>" type="checkbox"> <?php echo $item; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div> 
                                <div style="clear: both;"></div>
                                <br/>
                                <div class="form-group">
                                    <label for="color">Kích thước</label>
                                    <div style="clear: both;">
                                        <?php
                                        $color = $attribute_types[1]['attr'];
                                        if ($color)
                                            $color = explode(',', $color);
                                        ?>
                                        <?php foreach ($color as $item): ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="attr_size" value="<?php echo $item; ?>" type="checkbox"> <?php echo $item; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div> 
                                <br/><br/><br/>
                                <a id="add_attr" style="width: 200px;" class="btn btn-block btn-primary">Thêm thuộc tính</a>
                                <br/>
                                <table class="table table_attr table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>                                        
                                            <th >Màu sắc</th>
                                            <th>kích thước</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                   
                                    </tbody>
                                </table>
                            </div>                                                
                        </div>    
                    </div>
                    <br/>
                    <div  class="row">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">SEO</h3>
                            </div>
                            <div class="box-body">                                
                                <div class="form-group">
                                    <label for="seo_title">Seo title</label>
                                    <input type="text" class="form-control" name="seo_title">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta description</label>
                                    <input type="text" class="form-control" name="meta_description">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keyword">Meta keyword</label>
                                    <input type="text" class="form-control" name="meta_keyword">
                                </div>
                            </div>
                            <div style="display: none;">
                                <?php foreach ($attribute_types as $item): ?>
                                    <?php if ($item['key'] != 'color' && $item['key'] != 'size' && $item['attr']): ?>
                                        <div rel="<?php echo $item['key']; ?>" class="box-body attr_filter">
                                            <div class="form-group">
                                                <label for="color"><?php echo $item['name']; ?></label>
                                                <div style="clear: both;">
                                                    <?php $attr = explode(',', $item['attr']); ?>
                                                    <?php foreach ($attr as $a): ?>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input name="<?php echo $item['key']; ?>[]"  value="<?php echo $a; ?>" type="checkbox"> <?php echo $a; ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>                                    
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="clear: both;"></div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <textarea name="content" id="content"></textarea>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

</div>
<script src="/assets/admin/js/product.js"></script>
<script>
    //crop('photo', 300, 400);
    $('select[name="cat_id"]').change();
    $('form').submit(function () {

        if ($('form').valid() && $('.table_attr tbody tr').length == 0) {
            alert('Vui lòng chọn màu sắc');
            $("html, body").animate({scrollTop: "0"});
            return false;
        }
    });
</script>
<style>
    div.checkbox{width: 25%;float: left;margin-top: 0px;}
    .checkbox+.checkbox, .radio+.radio{     margin-top: 0px;}
</style>

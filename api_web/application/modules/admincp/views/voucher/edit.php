<div class="content-wrapper">    
    <section class="content-header">
        <h1>Chỉnh sửa sản phẩm</h1>
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
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" value="<?php echo $product['title']; ?>"  name="title">
                            </div>                           
                            <div class="form-group">
                                <label for="cat_id">Loại sản phẩm</label>
                                <select name="cat_id" class="form-control">
                                    <option value="">-- Chọn loại sản phẩm --</option>
                                    <?php foreach ($categories as $item): ?>
                                        <option <?php echo $item['id'] == $product['cat_id'] ? 'selected' : ''; ?> rel="<?php echo $item['attr_type_keys']; ?>" value="<?php echo $item['id']; ?>"><?php echo $item['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>  
                            <div class="form-group">
                                <label for="price">Giá bán</label>
                                <input type="text" value="<?php echo $product['price']; ?>" class="form-control format_number" name="price">
                            </div> 
                            <div class="form-group">
                                <label for="price_compare">Giá so sánh</label>
                                <input type="text" value="<?php echo $product['price_compare']; ?>" class="form-control format_number" name="price_compare">
                            </div> 
                            <p>
                                <label for="image">Hình từ file</label>                    
                                <input id="photo"  type="file" accept="image/*" /><br/>                    
                            </p>

                            <br/><br/>
                            <fieldset>
                                <legend>Danh sách hình trong album</legend>
                                <input type="file" accept="image/*" id="images" name="images[]" multiple />
                                <div id="image" class="image_product_details">

                                </div>
                                <div style="clear: both"></div>
                                <hr/>
                                <div class="image_product_details">
                                    <?php if (!empty($images)): ?>
                                        <?php foreach ($images as $item): ?>                       
                                            <div class="row">
                                                <img src="<?php echo "/assets/upload/product/{$product['folder']}/goc/{$item['name']}"; ?>"/>                                                                     
                                                <a href="javascript:void(0)"  onclick="del(<?php echo $item['id']; ?>, this)" >DEL</a>
                                            </div>                                                                                 
                                        <?php endforeach; ?>                                                                          
                                    <?php endif; ?>          
                                </div>
                                <input type="hidden" value="" name="order_image" />
                            </fieldset>
                            <br/><br/><br/>
                            <div class="form-group">
                                <label for="seo_title">Seo title</label>
                                <input type="text" value="<?php echo $product['seo_title']; ?>" class="form-control" name="seo_title">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta description</label>
                                <input type="text" value="<?php echo $product['meta_description']; ?>" class="form-control" name="meta_description">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Meta keyword</label>
                                <input type="text" value="<?php echo $product['meta_keyword']; ?>" class="form-control" name="meta_keyword">
                            </div>
                        </div>                            

                    </div>    

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="box box-primary box-success">                       
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="color">Màu sắc</label>
                                    <div style="clear: both;">
                                        <?php
                                        $color = $attribute_types[0]['attr'];
                                        if ($color)
                                            $color = explode(',', $color);
                                        ?>
                                        <?php foreach ($color as $item): ?>
                                            <div class="checkbox"><label><input class="attr_color" value="<?php echo $item; ?>" type="checkbox"> <?php echo $item; ?></label></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div style="clear: both"></div>
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
                                <div style="display: none;" class="alert alert-success alert-dismissable add_attr_success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                                   
                                    thêm thành công
                                </div>
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
                                        <?php if (!empty($skus)): ?>
                                            <?php $first_color = ''; ?>
                                            <?php foreach ($skus as $item): ?>
                                                <?php if ($first_color != $item['color']): ?>
                                                    <?php $first_color = $item['color']; ?>
                                                    <tr color="<?php echo $item['color']; ?>">
                                                        <td rowspan="2" class="main_color" color="<?php echo $item['color']; ?>"><?php echo $item['color']; ?></td>
                                                        <td colspan="2">
                                                            <input style="float: left;margin-top: 13px;" type="file" name="<?php echo str_replace(' ', '_', $item['color']); ?>">
                                                            <img src="/assets/upload/product/<?php echo $product['folder'] . '/' . $item['image']; ?>"/>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr id="<?php echo $item['id']; ?>" color="<?php echo $item['color']; ?>" rel="<?php echo $item['color'] . '|' . $item['size']; ?>">
                                                    <td><?php echo $item['size']; ?></td>
                                                    <td><a class="del_attr" href="javscript:void(0)">Xoá</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>                                                
                        </div>    
                    </div>

                    <div class="row">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Bộ lọc</h3>
                            </div>
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
                                                            <input <?php echo strpos($product[$item['key']], ',' . $a . ',') !== false ? 'checked' : ''; ?> name="<?php echo $item['key']; ?>[]"  value="<?php echo $a; ?>" type="checkbox"> <?php echo $a; ?>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <textarea name="content" id="content"><?php echo $product['content']; ?></textarea>
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
    var admin_url = "<?php echo base_url() . ADMIN_URL . 'product/'; ?>";
    crop('photo', 315, 315<?php echo $product['image'] ? ',"/assets/upload/product/' . $product['folder'] . '/' . $product['image'] . '"' : ''; ?>);
    $('select[name="cat_id"]').change();
    $('td.main_color').each(function () {
        var color = $(this).attr('color');
        var count = $('tr[color="' + color + '"]').length;
        $(this).attr('rowspan', count);
    });
    function del(id,_this) {
        $.post(admin_url+'del_product_image',{id:id},function(){
           $(_this).parent().remove(); 
        });
    }
</script>
<style>
    div.checkbox{width: 25%;float: left;margin-top: 0px;}
    .checkbox+.checkbox, .radio+.radio{     margin-top: 0px;}    
</style>

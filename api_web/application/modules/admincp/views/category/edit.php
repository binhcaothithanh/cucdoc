<div class="content-wrapper">
    <section class="content-header">
        <h1>Chỉnh sửa thể loại</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>admin">Danh sách thể loại</a></li>
        </ol>
    </section>
    <section class="content">

        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php
                     if ($check_error == 0): ?>
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
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Tên thể loại</label>
                                <input type="text" class="form-control" name="title" value="<?php echo $category['title']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="class">Category Parent</label>
                                <select name="parent_id" class="form-control">
                                    <?php
                                    foreach($category_parents as $item):
                                       if(isset($category_parents[$item['id']]) && $item['id'] != $category['id']):
                                        ?>
                                        <option <?php echo $category['parent_id'] == $item['id'] ? 'selected' : ''; ?> value="<?php echo $item['id']; ?>"><?php echo(PRE_CATEGORY_CHILD . $item['title'] . PRE_CATEGORY_CHILD); ?></option>
                                        <?php
                                         if(isset($category_parents[$item['id']]['childs'])):
                                        foreach($category_parents[$item['id']]['childs'] as $item1):
                                           if(  $item1['id'] != $category['id']):
                                            ?>
                                            <option <?php echo $category['parent_id'] == $item1['id'] ? 'selected' : ''; ?> value="<?php echo $item1['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . $item1['title']); ?></option>
                                            <?php
                                            if(isset($category_parents[$item1['id']]['childs'])):
                                            foreach($category_parents[$item1['id']]['childs'] as $item2):
                                               if( $item2['id'] != $category['id'] ):
                                                ?>
                                                <option <?php echo $category['parent_id'] == $item2['id'] ? 'selected' : ''; ?> value="<?php echo $item2['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item2['title']); ?></option>
                                                <?php
                                                  if(isset($category_parents[$item2['id']]['childs'])):
                                                  foreach($category_parents[$item2['id']]['childs'] as $item3):
                                                    if( $item3['id'] != $category['id']):
                                                    ?>
                                                    <option <?php echo $category['parent_id'] == $item3['id'] ? 'selected' : ''; ?> value="<?php echo $item3['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item3['title']); ?></option>
                                                    <?php
                                                      if(isset($category_parents[$item3['id']]['childs'])):
                                                      foreach($category_parents[$item3['id']]['childs'] as $item4):
                                                        if( $item4['id'] != $category['id']):
                                                        ?>
                                                        <option <?php echo $category['parent_id'] == $item4['id'] ? 'selected' : ''; ?> value="<?php echo $item4['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item4['title']); ?></option>
                                                        <?php
                                                        endif;
                                                      endforeach;
                                                   endif;
                                                   unset($category_parents[$item3['id']]);
                                                  endif;
                                                  endforeach;
                                                endif;

                                                unset($category_parents[$item2['id']]);
                                                endif;
                                            endforeach;
                                          endif;
                                          unset($category_parents[$item1['id']]);
                                          endif;
                                        endforeach;
                                      endif;

                                      unset($category_parents[$item['id']]);
                                      endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Banner(150x186)</label>
                                <input type="file" class="form-control" name="image">
                                <img style="width: 300px;"  src="/assets/upload/category/<?php echo $category['image']; ?>"/>
                            </div>
                            <div style="display: none;">
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <input type="text" class="form-control" value="<?php echo $category['class']; ?>" name="class">
                                </div>
                                <div class="form-group">
                                    <label for="attr_type">Loại thuộc tính</label>
                                    <div style="clear: both;">
                                        <?php $attr_type_keys = ',' . $category['attr_type_keys'] . ','; ?>
                                        <?php foreach ($attr_types as $item): ?>
                                            <?php if ($item['key'] != 'color' && $item['key'] != 'size'): ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input <?php echo strpos($attr_type_keys, ',' . $item['key'] . ',') !== false ? 'checked' : ''; ?> name="attr_type[]"  value="<?php echo $item['key']; ?>" type="checkbox"> <?php echo $item['name']; ?>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="seo_title">Seo title</label>
                                <input type="text" class="form-control" value="<?php echo $category['seo_title'];?>" name="seo_title">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta description</label>
                                <textarea class="form-control" name="meta_description"><?php echo $category['meta_description'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Meta keyword</label>
                                <input type="text" class="form-control" value="<?php echo $category['meta_keyword'];?>" name="meta_keyword">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Partner name</label>
                                <input type="text" class="form-control" value="<?php echo $category['partner_name'];?>" name="partner_name">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Partner link</label>
                                <input type="text" class="form-control" value="<?php echo $category['partner_link'];?>" name="partner_link">
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
            title: {required: true}
        },
        messages: {
            'title': 'Vui lòng nhập tên thể loại'
        }
    });
    function del(id) {
        show_dialog('Bạn có muốn thuộc tính id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>category/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>
<style>
    div.checkbox{width: 33%;float: left;margin-top: 0px;}
    .checkbox+.checkbox, .radio+.radio{     margin-top: 0px;}
</style>

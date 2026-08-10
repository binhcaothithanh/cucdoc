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
                                <label for="name">Tên thể loại</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label for="class">Category Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="<?php echo(CATEGORY_ROOT_ID); ?>"> --- ROOT --- </option>
                                    <?php foreach($category_parents as $item):
                                       if(isset($category_parents[$item['id']]) && $item['id'] != CATEGORY_ROOT_ID):
                                        ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo(PRE_CATEGORY_CHILD . $item['title'] . PRE_CATEGORY_CHILD); ?></option>
                                        <?php
                                         if(isset($category_parents[$item['id']]['childs'])):
                                        foreach($category_parents[$item['id']]['childs'] as $item1):
                                            ?>
                                            <option value="<?php echo $item1['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item1['title']); ?></option>
                                            <?php
                                            if(isset($category_parents[$item1['id']]['childs'])):
                                            foreach($category_parents[$item1['id']]['childs'] as $item2):
                                                ?>
                                                <option value="<?php echo $item2['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item2['title']); ?></option>
                                                <?php
                                                  if(isset($category_parents[$item2['id']]['childs'])):
                                                  foreach($category_parents[$item2['id']]['childs'] as $item3):
                                                    ?>
                                                    <option  value="<?php echo $item3['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item3['title']); ?></option>
                                                    <?php
                                                      if(isset($category_parents[$item3['id']]['childs'])):
                                                      foreach($category_parents[$item3['id']]['childs'] as $item4):
                                                        ?>
                                                        <option value="<?php echo $item4['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item4['title']); ?></option>
                                                        <?php
                                                      endforeach;
                                                   endif;
                                                   unset($category_parents[$item3['id']]);

                                                  endforeach;
                                                endif;

                                                unset($category_parents[$item2['id']]);
                                            endforeach;
                                          endif;
                                          unset($category_parents[$item1['id']]);
                                        endforeach;
                                      endif;

                                      unset($category_parents[$item['id']]);
                                      endif;
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Banner(150x186)</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div style="display: none;">
                                <div class="form-group">
                                    <label for="class">Class</label>
                                    <input type="text" class="form-control" name="class">
                                </div>

                                <div class="form-group">
                                    <label for="attr_type">Loại thuộc tính</label>
                                    <div style="clear: both;">
                                        <?php foreach ($attr_types as $item): ?>
                                            <?php if ($item['key'] != 'color' && $item['key'] != 'size'): ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="attr_type[]"  value="<?php echo $item['key']; ?>" type="checkbox"> <?php echo $item['name']; ?>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="seo_title">Seo title</label>
                                <input type="text" class="form-control" name="seo_title">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Meta description</label>
                                <textarea class="form-control" name="meta_description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword">Meta keyword</label>
                                <input type="text" class="form-control" name="meta_keyword">
                            </div>
                            <div class="form-group">
                                <label for="partner_name">partner_name</label>
                                <input type="text" class="form-control" name="partner_name">
                            </div>
                            <div class="form-group">
                                <label for="partner_link">partner_link</label>
                                <input type="text" class="form-control" name="partner_link">
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

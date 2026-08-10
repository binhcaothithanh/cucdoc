<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">
                    <th>ID</th>
                    <th>Tên SP</th>
                    <th>image</th>
                    <th>Hot</th>
                    <th>Giá bán</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><a href="/<?php echo ADMIN_URL . 'product/edit/' . $item['id']; ?>"><?php echo $item['title'] . '(' . $item['count'] . ')'; ?></a></td>
                        <!-- <td><img height="30" src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['image']; ?>"/></td>
                        -->
                        <?php if(strpos($item['image'], 'http') === false): ?>
                          <td><img height="30" src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['image']; ?>"/></td>
                        <?php else: ?>
                        <td><img height="30" src="<?php echo explode(',', $item['image'])[0]; ?>"/></td>
                      <?php endif; ?>

                        <td><input <?php echo $item['is_hot'] ? 'checked' : ''; ?> type="checkbox" class="is_hot" rel="<?php echo $item['id']; ?>"/></td>
                        <td><input class="price format_number" value="<?php echo $item['price']; ?>"/></td>
                        <td <?php
                        if($role == 'partner'){
                        	echo('style="display:none"');
                        }
                        ?> >
                            <a href="/<?php echo ADMIN_URL . 'product/edit/' . $item['id']; ?>">Edit</a> |
                            <a onclick="del(<?php echo $item['id']; ?>)" href="javascript:void(0)">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-4 col-md-offset-5">
    <div class="pagination">
        <?php echo $links; ?>
    </div>
</div>
<script>
    $('.format_number').autoNumeric('init', {aPad: false});
</script>

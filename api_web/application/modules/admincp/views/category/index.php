<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Danh sách thể loại</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
        <br/>
        <a href="/<?php echo ADMIN_URL; ?>category/add"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm thể loại</button></a><br />
        <!-- <a href="/<?php echo ADMIN_URL; ?>category/addcat"><button style="width: 200px;" class="btn btn-block btn-primary">Thêm thể loại by link</button></a> -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     foreach ($results as $item):
                                       if(isset($results[$item['id']])):
                                        ?>
                                        <tr>
                                            <td><?php
                                             echo $item['id']; ?></td>
                                            <td>
                                              <?php echo $item['title']; ?>
                                            </td>

                                            <td>
                                              <?php if($item['id'] != CATEGORY_ROOT_ID):
                                              ?>
                                                <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item['id']; ?>">Edit</a> |
                                                <a href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Delete</a>
                                                <?php
                                              endif;
                                                 ?>
                                            </td>
                                        </tr>
                                        <?php
                                         if (isset($item['childs'])): ?>
                                            <?php foreach ($item['childs'] as $item_child):
                                                     ?>
                                                        <tr>
                                                            <td><?php echo $item_child['id']; ?></td>
                                                            <td>  <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child['id']; ?>"> <?php echo PRE_CATEGORY_CHILD . $item_child['title']; ?></a>  </td>
                                                            <td>
                                                                <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child['id']; ?>">Edit</a> |
                                                                <a href="javascript:void(0)" onclick="del(<?php echo $item_child['id'] ?>)">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php

                                                    if(isset($results[$item_child['id']]['childs'] )):
                                                       foreach ($results[$item_child['id']]['childs'] as $item_child2):
                                                          ?>
                                                          <tr>
                                                              <td><?php echo $item_child2['id']; ?></td>
                                                              <td> <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child2['id']; ?>">  <?php echo PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item_child2['title']; ?> </a></td>
                                                              <td>
                                                                  <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child2['id']; ?>">Edit</a> |
                                                                  <a href="javascript:void(0)" onclick="del(<?php echo $item_child2['id'] ?>)">Delete</a>
                                                              </td>
                                                          </tr>
                                                      <?php
                                                      if(isset($results[$item_child2['id']]['childs'] )):
                                                          foreach ($results[$item_child2['id']]['childs'] as $item_child3):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $item_child3['id']; ?></td>
                                                                <td><a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child3['id']; ?>">   <?php echo PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item_child3['title']; ?> </a></td>
                                                                <td>
                                                                    <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child3['id']; ?>">Edit</a> |
                                                                    <a href="javascript:void(0)" onclick="del(<?php echo $item_child3['id'] ?>)">Delete</a>
                                                                </td>
                                                            </tr>
                                                          <?php
                                                            if(isset($results[$item_child3['id']]['childs'])):
                                                              foreach ($results[$item_child3['id']]['childs'] as $item_child4):
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $item_child4['id']; ?></td>
                                                                    <td> <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child4['id']; ?>">  <?php echo PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item_child4['title']; ?></a></td>
                                                                    <td>
                                                                        <a href="/<?php echo ADMIN_URL . 'category/edit/' . $item_child4['id']; ?>">Edit</a> |
                                                                        <a href="javascript:void(0)" onclick="del(<?php echo $item_child4['id'] ?>)">Delete</a>
                                                                    </td>
                                                                </tr>
                                                              <?php
                                                              unset($results[$item_child4['id']]);
                                                              endforeach;
                                                            endif;
                                                            unset($results[$item_child3['id']]);
                                                        endforeach;
                                                      endif;
                                                      unset($results[$item_child2['id']]);
                                                      endforeach;
                                                    endif;
                                                    unset($results[$item_child['id']]);
                                                  endforeach;
                                            endif;
                                       endif;
                                        unset($results[$item['id']]);
                                      endforeach; ?>
                                </tbody>
                            </table>
                            </table>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section>
</div><!-- /.row -->

<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa thể loại id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>category/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

</script>

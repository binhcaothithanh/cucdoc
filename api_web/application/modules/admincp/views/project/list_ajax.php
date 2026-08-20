
<!-- Main content -->
<!-- <section class="content"> -->
    <div class="row">
      <div class="col-md-6">
            <div class="box box-primary box-success">
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th>Dự Án</th>
                                    <th>$</th>
                                    <th>trạng Thái</th>
                                    <th>Ngày Tạo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $totalMoney = 0;
                                 foreach ($results as $item): ?>
                                    <tr>
                                        <td>
                                          <a style="margin-top: 10px" href="/<?php echo ADMIN_URL . 'projectdetails?project_id=' . $item['id']; ?>"><?php echo $item['project_name']; ?></a>
                                        </td>
                                        <td><p
                                          <?php if ($item['current_money'] < 0):
                                            echo('style="color: #FF0000"');
                                          endif;
                                           ?>
                                          ><?php
                                          if($item['type'] == 'money'):
                                          $totalMoney += $item['current_money'];
                                           echo number_format($item['current_money']);
                                         else:
                                           echo("SL tồn: " . $item['current_money']);
                                         endif;
                                           ?></p></td>
                                        <td><?php echo $item['status'] == "open" ? "Mở" : "Đóng"; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($item['created_date'])); ?></td>
                                        <td>

                                            <a style="margin-top: 10px" class="btn btn-primary" href="/<?php echo ADMIN_URL . 'projectdetails?project_id=' . $item['id']; ?>">$</a>
                                            <a style="margin-top: 10px" class="btn btn-primary" href="/<?php echo ADMIN_URL . 'project/edit/' . $item['id']; ?>">Edit</a>
                                            <?php  if($user['role'] == 'admin'): ?>
                                            <a style="margin-top: 10px" class="btn btn-primary" href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Del</a>
                                          <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                  <td>
                                    Tổng tiền:
                                  </td>
                                  <td colspan="4"><p style="font-weight: bold">
                                    <?php echo number_format($totalMoney); ?>
                                  </p>
                                  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
<!-- </section> -->


<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa tài khoản id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>/project/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

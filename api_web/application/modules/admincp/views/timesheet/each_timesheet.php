<?php
  $total_money = 0;
    foreach ($results as $item):
      // var_dump($item);
      // die;
      if(isset($item['total_sell'])):
        $total_money += $item['total_sell'];
      endif;
    endforeach;
   ?>
<div style="font-size: 25pt; font-weight: bold">
  Tổng tiền: <?php echo number_format($total_money); ?>
</div>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary box-success">
          <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                      <thead>
                          <tr role="row">
                              <th>Sinh Viên</th>
                              <th>Trạng Thái</th>
                              <th>Actions</th>
                              <th>Ngày Làm</th>
                              <th>Tiền Bán Được</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                           foreach ($results as $item): ?>
                              <tr>
                                  <td><?php
                                  if(isset($item['student_name'])):
                                   echo $item['student_name'];
                                 else:
                                   echo $student_name;
                                 endif;

                                   ?>
                                 </td>
                                 <td
                                 <?php if($item['state_transaction'] == 'open'):
                                     echo('style="color: orange; font-weight: bold"');
                                 else: // Done
                                     echo('style="color: green; font-weight: bold"');
                                 endif;?>
                                 >
                                   <?php echo $item['state_transaction']; ?></td>
                                 <td>
                                     <a href="/<?php echo ADMIN_URL . 'StudentTransaction/edit/' . $item['id']; ?>">Edit</a> <br /><br />
                                     <a href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Delete</a>
                                 </td>
                                  <td><?php echo $item['created_date']; ?></td>
                                  <td><?php echo number_format($item['total_sell']); ?></td>

                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa tài khoản id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>StudentTransaction/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>

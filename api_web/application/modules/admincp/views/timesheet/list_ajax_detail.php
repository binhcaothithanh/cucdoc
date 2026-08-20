<?php
if (!isset($results[0])):
  echo('no data');
  die;
endif;
?>
<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <thead>
      <tr role="row">
          <th>Name</th>
          <th>Date</th>
          <th>Time in</th>
          <th>Time out</th>
          <th>Total Hour<th>
      </tr>
      <?php
        $total_time = 0;
        $salary_used = 0;
          foreach($results as $each):
      ?>
      <tr>
          <td><?php echo($each['username']) ?> (
          <a href="/<?php echo ADMIN_URL . 'timesheet/editTimeSheetDetails/' . $each['timesheet_id']; ?>">Edit</a> |
          <a href="javascript:void(0)" onclick="del(<?php echo $each['timesheet_id'] ?>)">Delete</a>)
          </td>
          <td><?php echo($each['created_date']) ?></td>
          <td><?php echo($each['in_time']) ?></td>
          <td><?php echo($each['out_time']) ?></td>
          <td>
          <?php  
            // $start_t = new DateTime($each['in_time']);
            // $current_t = new DateTime($each['out_time']);
            // $difference = $start_t ->diff($current_t );
            // $return_hour = $difference ->format('%H');
            // $return_minus = $difference ->format('%I');
            // $return_time = $return_hour + $return_minus/60;
            // $total_time += $return_time;
            // $salary_used += $each['salary_used'];

            // echo($return_time);
            $total_time += $each['total_time'];
            $salary_used += $each['salary_used'];
            echo($each['total_time']);
            ?>
          </td>
      </tr>
      <?php 
          endforeach;
          // list_group
      ?>
      <tr>
          <td colspan="4">

            <p style="float: right; font-weight: bold">Nhân viên:  </p>
        </td>
        <td>
            <p style="float: left; font-weight: bold">
            <?php
                  echo($results[0]['username']);
            ?>
            </p>
          </td>
      </tr>
      <tr>
        <td colspan="4" >
            <p style="float: right; font-weight: bold">Số tiếng:</p>
        </td>
        <td>
          <?php
            echo($total_time);
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" >
          <p style="float: right; font-weight: bold">Lương <?php echo($results[0]['group_name']) ?>:</p>
        </td>
        <td>
          <?php
            echo(number_format($results[0]['money']) . ' đ');
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" >
            <p style="float: right; font-weight: bold">Tiền lương:</p>
        </td>
        <td>
          <?php
            echo(number_format($results[0]['money'] * $total_time) . ' đ');
          ?>
        </td>
      </tr>
      <?php if($salary_used > 0): ?>
      <tr>
        <td colspan="4" >
            <p style="float: right; font-weight: bold">Ứng Lương:</p>
        </td>
        <td>
          <?php
            echo(number_format($salary_used) . ' đ');
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" >
            <p style="float: right; font-weight: bold">Thực lãnh:</p>
        </td>
        <td>
          <?php
            echo(number_format($results[0]['money'] * $total_time - $salary_used) . ' đ');
          ?>
        </td>
      </tr>
      <?php endif; ?>
  </thead>
</table>
<script>
    function del(id) {
        show_dialog('Bạn có muốn xóa id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>timesheet/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }

</script>

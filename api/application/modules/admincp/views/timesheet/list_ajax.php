<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <thead>
      <tr role="row">
          <th>NV</th>
          <th>Total Hours</th>
          <th>Salary Used</th>
          <th>Total Money</th>
      </tr>
      <?php
        $total_money = 0;
          foreach($results as $each):
      ?>
      <tr>
          <td>
            <a href="/<?php  echo ADMIN_URL; ?>timesheet/details<?php echo('?user_id=' . $each['id'] . '&fromTime=' . $fromTime . '&toTime=' . $toTime) ?>"> <?php echo($each['username'] . ' ('.$each['money'].')') ?></a>  
          </td>
          <td><?php echo($each['total_time']) ?></td>
          <td><?php echo($each['salary_used']) ?></td>
          <td><?php echo(number_format(($each['total_time']) * $each['money']) . ' đ');  ?></td>
      </tr>
      <?php 
          $total_money += ($each['total_time']) * $each['money'] - $each['salary_used'];
          endforeach;
      ?>
      <tr>
        <td colspan="2" >
            <p style="float: right; font-weight: bold">Total money:</p>
        </td>
        <td colspan="2" >
          <?php echo(number_format($total_money) . ' đ'); ?>
        </td>
        </tr>
  </thead>
</table>
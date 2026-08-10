<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Dự Án: <?php echo($project['project_name']) ?></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL . "project" ?>" >Danh sách dự án</a></li>
            <li class="active">Dự án <?php echo  $project['project_name']; ?></li>
        </ol>
        <BR />
        Nội dung: <?php echo  $project['note']; ?>
        <br /><br />
        <a style="width: 200px;"  class="btn btn-block btn-primary" href="/<?php echo ADMIN_URL; ?>projectdetails/add?type=pay&project_id=<?php echo ($project['id'])?>">Chi Tiền</a>
        <br/>
        <a style="width: 200px;"  class="btn btn-block btn-primary" href="/<?php echo ADMIN_URL; ?>projectdetails/add?type=receive&project_id=<?php echo ($project['id'])?>">Thu Tiền</a>
        <br />
        <h1> Tài chính hiện tại: <?php echo(number_format($total_receive - $total_pay)); ?></h1>
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
                                        <th>$</th>
                                        <!-- <th>Admin</th> -->
                                        <th>Thời gian</th>
                                        <!-- <th>C/T</th> -->
                                        <th>Nội Dung</th>
                                        <?php  if($user['role'] == 'admin'): ?>
                                          <th>Function</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($results as $item): ?>
                                        <tr>
                                            <td>
                                              <a
                                              <?php
                                              if ($item['status'] == 'pay'):
                                                echo('style="color: #FF0000"');
                                              endif;
                                               ?>
                                               href="/<?php echo ADMIN_URL . 'projectdetails/watch/' . $item['id']; ?>">
                                                <?php
                                                echo $item['status'] == 'pay'? "-" : "+";
                                                echo number_format($item['money']); ?>
                                              </a>
                                            </td>
                                            <!-- <td>
                                              <a href="/<?php echo ADMIN_URL . 'projectdetails/watch/' . $item['id']; ?>">
                                              <?php echo $item['created_user']; ?>
                                              </a>
                                            </td> -->
                                            <td>
                                              <a href="/<?php echo ADMIN_URL . 'projectdetails/watch/' . $item['id']; ?>">
                                              <?php echo date("d/m/Y" , strtotime($item['created_date'])); ?>
                                              </a>
                                            </td>
                                            <!-- <td>
                                              <a href="/<?php echo ADMIN_URL . 'projectdetails/watch/' . $item['id']; ?>">
                                              <?php if($item['status'] == 'pay'):
                                                      if($item['approved'] == 1):
                                                        echo('Chi - (đã tt)');
                                                      else:
                                                        echo('Chi');
                                                      endif;
                                                    else:
                                                        echo('Thu');
                                                    endif;
                                                 ?>
                                              </a>
                                            </td> -->
                                            <td>
                                              <a  href="/<?php echo ADMIN_URL . 'projectdetails/watch/' . $item['id']; ?>">
                                              <?php echo $item['content']; ?>
                                              </a>
                                            </td>
                                      <?php  if($user['role'] == 'admin'): ?>
                                            <td>
                                                <a style="margin-top:10px" class="btn btn-primary" href="/<?php echo ADMIN_URL . 'projectdetails/edit/' . $item['id']; ?>">Edit</a>
                                                <a style="margin-top:10px" class="btn btn-primary" href="javascript:void(0)" onclick="del(<?php echo $item['id'] ?>)">Del</a>
                                            </td>
                                      <?php  endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
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
        show_dialog('Bạn có muốn xóa tài khoản id =' + id + ' không', function () {
          var project_id = <?php echo($project['id']); ?>;
            $.post('/<?php echo ADMIN_URL; ?>projectdetails/del', {id: id, project_id: project_id}, function (results) {
                location.reload();
            });
        });
    }
</script>

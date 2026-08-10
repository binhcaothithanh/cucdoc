<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">                  
                    <th>Username</th>
                    <th>Kết quả</th>                                                            
                </tr>
            </thead>
            <tbody>    
                <?php if (!empty($results)): ?>

                    <?php
                    $data = array();
                    foreach ($results as $item) {
                        if ($item['status'] == 'approved') {
                            @$data[$item['username']]['success'] +=$item['count_status'];
                        }
                        @$data[$item['username']]['total'] +=$item['count_status'];
                    }                   
                    ?>
                    <?php foreach ($data as $k => $v): ?>
                        <tr>
                            <td><?php echo $k; ?></td>                     
                            <td><?php echo intval(@$v['success']) . '/' . $v['total']; ?></td>                                 
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">Không có kết quả</td>
                    </tr>
                <?php endif; ?>
            </tbody>      
        </table>
    </div>
</div>


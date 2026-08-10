<div class="box-body">
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">                  
                    <th>ID</th>
                    <th>Code</th>
                    <th>Status</th>                    
                    <th>Giá</th>                
                    <th>Actions</th>                                                
                </tr>
            </thead>
            <tbody>    
                <?php foreach ($results as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>                     
                        <td><?php echo $item['code']; ?></td>                                                  
                        <td><?php echo $item['status']; ?></td>                                                                                                                     
                        <td><?php echo number_format($item['price'])  .' '. $item['type']; ?></td>                                                  
                        <td><a onclick="del(<?php echo $item['id']; ?>)" href="javascript:void(0)">Delete</a> </td>
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

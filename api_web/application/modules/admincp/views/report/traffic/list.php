<div class="sTableWrapper" style="padding: 5px;"> 
    <div class="col-xs-7">
        <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
                <tr role="row">                  
                    <th>Source</th>
                    <th>MÃ SP</th>                                                            
                    <th>Tên SP</th>                                                            
                    <th>Mua</th>                                                            
                    <th>View</th>                                                            
                </tr>
            </thead>       
            <?php if (!empty($results)): ?>
                <?php
                $total_view = $total_buy = $i = 0;
                ?>
                <?php foreach ($results as $item): ?>
                    <?php
                    $total_view+= $item['view'];
                    $total_buy+= $item['buyed'];
                    ?>
                    <?php if ($i < 20): ?>
                        <tr class="gradeC ">   
                            <td><?php echo $item['source']; ?></td>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo $item['product_name']; ?></td>

                            <td class="format_number"><?php echo $item['buyed']; ?></td>
                            <td class="format_number"><?php echo $item['view']; ?></td>                    
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr style="background: #D2A6AE;">
                    <td colspan="3">Tổng</td>
                    <td class="format_number"><?php echo $total_buy; ?></td>
                    <td class="format_number"><?php echo $total_view; ?></td>                
                </tr>
            <?php else: ?>
                <tr><td colspan="10">Khong co thong ke</td></tr>
            <?php endif; ?>

        </table>
    </div>
    <div class="col-xs-5">
        <table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">

            <tr class="sTableHead" >  
                <th>Chiến dịch</th>
                <th>Thiết bị</th>                            
                <th>Số đơn hàng</th>                                   
            </tr>
            <?php if (!empty($orders)): ?>
                <?php
                $source = $total_order = 0;
                ?>
                <?php foreach ($orders as $item): ?>
                    <?php if ($item['source'] !== $source): ?>
                        <tr class="source">
                            <td colspan="3"><?php echo $source = $item['source']; ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr class="gradeC ">    
                        <td><?php echo $item['campaign']; ?></td>
                        <td><?php echo $item['device_type']; ?></td>                       
                        <?php
                        $total_order+= $item['count'];
                        ?>
                        <td class="format_number"><?php echo $item['count']; ?></td>                            
                    </tr>
                <?php endforeach; ?>
                <tr style="background: #D2A6AE;">
                    <td colspan="2">Tổng</td>
                    <td class="format_number"><?php echo $total_order; ?></td>                            
                </tr>
            <?php else: ?>
                <tr><td colspan="10">Khong co thong ke</td></tr>
            <?php endif; ?>

        </table>
    </div>

    <div style="clear: both;"></div>
</div>

<style>
    .empty{color: #999;}
    .source td{font-weight: bold;;background: #f4f4f4;}
</style>

<script>
    $('.format_number').autoNumeric('init', {aPad: false});
</script>
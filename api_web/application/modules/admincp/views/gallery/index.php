<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>LIST GALLERY</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List GALLERY</li>
        </ol>
        <br/>
        <a href="/<?php echo ADMIN_URL; ?>gallery/add"><button style="width: 130px;float: left;margin-right: 10px;"  class="btn btn-block btn-primary">ADD GALLERY</button></a>
        <select class="form-control" id="type" style="width: 150px;float: left;margin-right: 10px;">
            <option value=""> -- Tất cả -- </option>          
            <option value="slider"> Slider </option>          
            <option value="banner"> Banner </option>          
        </select> 
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" id="list_ajax">


                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </section>
</div><!-- /.row -->

<script>
     var current_pos = <?php echo $pos; ?>;
    function loadlist(pos) {
        current_pos = pos;
        var type = $('#type').val();
        $.post('/<?php echo ADMIN_URL; ?>gallery/page', {pos: pos, type: type}, function (results) {
            $('#list_ajax').html(results);
        });
    }
    $('#type').change(function () {
        loadlist(0);
    });

    loadlist(current_pos);
    $('#list_ajax').on('click', '.pagination a', function () {
        var pos = $(this).attr('href').replace('/', '');
        loadlist(pos);
        return false;
    });
    function del(id) {
        show_dialog('Bạn có muốn xóa gallery id =' + id + ' không', function () {
            $.post('/<?php echo ADMIN_URL; ?>gallery/del', {id: id}, function (results) {
                location.reload();
            });
        });
    }
</script>


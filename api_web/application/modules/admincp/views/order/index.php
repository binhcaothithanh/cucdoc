<div class="content-wrapper" style="min-height: 916px;">    <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Danh đơn hàngxx</h1>
     <ol class="breadcrumb">
        <li>
          <a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Danh đơn hàng</li>
      </ol>
      <select class="form-control" id="status" style="width: 20%;float: left;margin-right: 10px;">
        <option value="">  --  Tất cả -- </option>
        <?php foreach ($status_order as $k => $v): ?>
        <option <?php echo $status == $k ? 'selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
       <?php endforeach; ?>
     </select>
     <select class="form-control" style="width: 20%;float: left;margin-right: 10px; display:none" id="shipping_type">
       <option value="">--- Hình thức vận chuyển ---</option>
       <option value="post_office" <?php echo $shipping_type == 'post_office' ? 'selected' : ''; ?>>Bưu điện</option>
       <option value="f_shipping" <?php echo $shipping_type == 'f_shipping' ? 'selected' : ''; ?>>Chuyển phát nhanh</option>
     </select>
     <input class="form-control"  type="text" id="phone" style="width: 200px;" value="<?php echo @$_GET['phone']; ?>" placeholder="Nhập số dt của khách hàng"/>
   </section>    <br/>    <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">
         <div class="box" id="list_ajax">
         </div>
       </div><!-- /.box -->
     </div><!-- /.col -->
   </section>
</div><!-- /.row -->
<script>
  var current_pos = <?php echo $pos; ?>;
  function loadlist(pos) {        current_pos = pos;
    var status = $('#status').val();
    var phone = $('#phone').val();
    var shipping_type = $('#shipping_type').val();
    $.post('/<?php echo ADMIN_URL; ?>order/page', {status: status, pos: pos, phone: phone, shipping_type: shipping_type}, function (result) {            $('#list_ajax').html(result);        });    }    loadlist(current_pos);    $('#status').change(function () {        loadlist(0);    });    $('#shipping_type').change(function () {        loadlist(0);    });    $('#phone').keypress(function (e) {        if (e.keyCode == 13) {            loadlist(0);        }    });    $('#list_ajax').on('click', '.pagination a', function () {        var pos = $(this).attr('href').replace('/', '');        loadlist(pos);        return false;    });    function del(id) {        show_dialog('Bạn có muốn xóa hoá đơn id = ' + id + " không", function () {            $.post('/<?php echo ADMIN_URL; ?>order/del', {id: id}, function (results) {                loadlist(current_pos);            });        });    }</script>

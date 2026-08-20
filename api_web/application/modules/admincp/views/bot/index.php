<div class="content-wrapper" style="min-height: 916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Bot Page</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bot</li>
        </ol>
        <br/>

    </section>

    <!-- Main content -->
    <section class="content">
      <div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                      <div class="form-group">
                          <label for="linkfull">Link full</label>
                          <input type="text" class="form-control" name="linkfull" value="<?php echo $linkFull ?>" />
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="TotalPage">Total Page</label>
                          <input type="text" class="form-control" name="totalPage" value="<?php echo $totalPage; ?>" />
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="TotalPage">Current Page</label>
                          <select id="curPage" name="curPage" class="form-control">
                            <?php for ($i = 1; $i <= $totalPage; $i++){
                              echo("<option value='" . $i . "'>". $i ."</option>");
                            }
                             ?>
                             <option selected value="0">0</option>
                          </select>
                          <?php ?>
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="description">Status Scan:</label>
                          <br />
                          <input type="text" class="form-control" id="description" name="description" value="" />
                      </div>
                  </div>
                  <div class="box-footer">


                      <a  class="btn btn-primary" href="#" id="lnScallExercise">Scan All Exercises</a>
                      <a  class="btn btn-primary" href="#" id="lnScanSingleWorkout">Scan All Single Workout</a>
                      <a  class="btn btn-primary" href="#" id="lnUpdateSingleWorkout">Update Program Single Workout</a>
                      <a  class="btn btn-primary" href="#" id="lnScanWorkoutPlan">Scan All Program Workout Plan</a>

                      <label for="description">foreach workout plan 1-10:</label>
                      <input type="text" class="form-control" id="numberProgram" name="numberProgram" value="0" />
                      <a  class="btn btn-primary" href="#" id="lnUpdateWorkoutPlan">Update All Program Workout Plan</a>
                      <input placeholder="jv link" type="text" class="form-control" id="javlink" name="javlink" value="https://javhd.onl/cawd-339vietsub-hai-co-ban-than-dam-matsumoto-ichika-2551.html" />
                      <a class="btn btn-primary" href="#" id="lnjav" >get jav</a>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="link">link get all exercise</label>
                          <input type="text" class="form-control" id="link" name="link" value="<?php // echo $linkGet; ?>" />
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="linkSingleWorkout">Link Single Workout</label>
                          <input type="text" class="form-control" id="linkSingleWorkout" name="linkSingleWorkout" value="<?php // echo $linkSingleWorkout ?>" />
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="form-group">
                          <label for="linkSingleWorkout">Link All Workout Plan</label>
                          <input type="text" class="form-control" id="linkWorkoutPlan" name="linkWorkoutPlan" value="<?php // echo $linkWorkoutPlan ?>" />
                      </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div><!-- /.col -->
    </section>
</div><!-- /.row -->


<script>
//


$('#lnjav').click(function () {

  var link = $('#javlink').val();

  $('#description').val('getting value.....');

    $.post('/<?php  echo ADMIN_URL; ?>Bot/GetJv', {link: link}, function (result) {
      $('#description').val(result);
    });
});


$('#lnUpdateWorkoutPlan').click(function () {

  var numberProgram = $('#numberProgram').val();

  $('#description').val('getting value.....');

    $.post('/<?php  echo ADMIN_URL; ?>Bot/UpdateWorkoutPlanAjax', {numberProgram: numberProgram}, function (result) {
      $('#description').val(result);
    });
});

$('#lnScanWorkoutPlan').click(function () {

  var link = $('#linkWorkoutPlan').val();

  $('#description').val('getting value.....');

    $.post('/<?php  echo ADMIN_URL; ?>Bot/ScanWorkoutPlanAjax', {link: link}, function (result) {
      $('#description').val(result);
    });
});


      $('#lnUpdateSingleWorkout').click(function () {

        var link = $('#linkSingleWorkout').val();

        $('#description').val('getting value.....');

          $.post('/<?php  echo ADMIN_URL; ?>Bot/UpdateProgramDetailAjax', {link: link}, function (result) {
            $('#description').val(result);
          });
      });


      $('#lnScanSingleWorkout').click(function () {

        var link = $('#linkSingleWorkout').val();

        $('#description').val('getting value.....');

          $.post('/<?php  echo ADMIN_URL; ?>Bot/ReadSingleWorkoutAjax', {link: link}, function (result) {
            $('#description').val(result);
          });
      });
    // $('#lnEquip').click(function () {
    //   var link = $('#link').val();
    //
    //   $.post('/<?php  echo ADMIN_URL; ?>Bot/UpdateEquipAjax', {link: link}, function (result) {
    //     $('#description').val(result);
    //   });
    // });

      $('#lnScallExercise').click(function () {
        var curPage = $('#curPage').val();
        var link = $('#link').val();
        if(curPage == 0){
          alert('Finished scan');
          return;
        }
        $('#description').val('getting value.....');
        if($('#curPage').val() < <?php echo($totalPage); ?>){
          $.post('/<?php  echo ADMIN_URL; ?>Bot/ReadPerPageAjax', {link: link+curPage}, function (result) {
            $('#description').val(result);
          });

          $('#curPage').val(parseInt($('#curPage').val()) + 1);
        }else{
          // scan last time and set val = 0
          $.post('/<?php  echo ADMIN_URL; ?>Bot/ReadPerPageAjax', {link: link+curPage}, function (result) {
            $('#description').val(result);
          });
          alert('scan finish');
          $('#curPage').val(0);
        }
      });
</script>

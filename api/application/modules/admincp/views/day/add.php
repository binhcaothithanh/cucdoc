<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm day</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>day">Danh sách day_exercise</a></li>
        </ol>
    </section>
    <section class="content">
        <form id="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($check_error == 0) : ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4> <i class="icon fa fa-check"></i> Alert!</h4>
                            Thêm day_exercise thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1) : ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo @$msg; ?>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="day_name">day name (add first time)</label>
                                <input type="text" class="form-control" id="day_name" name="day_name" placeholder="Enter day name">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="day_number">day number</label>
                                <input type="text" class="form-control" id="day_number" name="day_number" placeholder="Enter day number">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="week_number">week number</label>
                                <select name="week_number" id="week_number" class="form-control" >
                                  <?php
                                  for ($x = 1; $x <= $total_week; $x++) {
                                    echo "<option value=".$x.">".$x."</option>";
                                    }
                                   ?>
                                </select>
                                <!-- <input type="text" class="form-control" id="week_number" name="week_number" placeholder="Enter week number"> -->
                              </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image_type">Image type (of day)</label>
                                <div style="overflow: scroll; border: 1px dotted red;">
                                  <UL>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>strengthtraining.png' style='height: 100px;' />
                                      <input checked type="radio" id="strengthtraining.png" name="image_type" value="strengthtraining.png">
                                      <label for="strengthtraining.png">Strength training</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>powerworkout.png' style='height: 100px;' />
                                      <input type="radio" id="powerworkout.png" name="image_type" value="powerworkout.png">
                                      <label for="powerworkout.png">Power Workout</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>upperbodystrength.png' style='height: 100px;' />
                                      <input type="radio" id="upperbodystrength.png" name="image_type" value="upperbodystrength.png">
                                      <label for="upperbodystrength.png">Upper body Strength</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>powerliftingtraining.png' style='height: 100px;' />
                                      <input type="radio" id="powerliftingtraining.png" name="image_type" value="powerliftingtraining.png">
                                      <label for="powerliftingtraining.png">Powerlifting Workout</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>rest.png' style='height: 100px;' />
                                      <input type="radio" id="rest.png" name="image_type" value="rest.png">
                                      <label for="rest.png">Rest</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>leg.png' style='height: 100px;' />
                                      <input type="radio" id="leg.png" name="image_type" value="leg.png">
                                      <label for="leg.png">Leg</label>
                                    </li>
                                    <li>
                                      <img src='<?php echo PATH_PROGRAM_IMAGE ?>chestshoulder.png' style='height: 100px;' />
                                      <input type="radio" id="chestshoulder.png" name="image_type" value="chestshoulder.png">
                                      <label for="chestshoulder.png">Chest & Shoulder</label>
                                    </li>
                                  </UL>
                              </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <br />
                                <textarea name="description" class="form-control" rows="10" id="description"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a  class="btn btn-primary" href="#" id="lnAdd">Add Each exercise</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" >
                  <div class="box box-primary box-success">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="muscleList">Muscle name</label>
                            <select id="muscleList" name="muscleList" class="form-control" >
                                <option value=""> --- muscle list --- </option>
                                <?php
                                foreach ($muscles as $muscle) : ?>
                                    <option value="<?php echo ($muscle['muscle_name']) ?>"><?php echo ($muscle['muscle_name']) ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-body" id="listExercise">

                    </div>
                    <div id="ValueExercise" style="display: none">
                      <div class="box-body">
                          <div class="form-group">
                              <label for="setvalue">set-value</label>
                              <input id="setvalue" type="text" class="form-control" name="setvalue" placeholder="Enter set-value number">
                          </div>
                      </div>
                      <div class="box-body">
                          <div class="form-group">
                              <label for="rep">rep</label>
                              <input id="rep" type="text" class="form-control" name="rep" placeholder="Enter rep number">
                          </div>
                      </div>
                      <div class="box-body">
                          <div class="form-group">
                              <label for="rest">rest</label>
                              <input id="rest" type="text" class="form-control" name="rest" placeholder="Enter rest number">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </form>
    </section>

</div>
<script>
function setHiddenIdValue(sel) {
        var level_name = $("#level_name option:selected").attr('idValue');
         document.getElementById("level_id").value = level_name;
    };

    // function loadListExercise(){
    //   alert('123');
    //   // var muscle_id = $('#muscleList').val();
    //   // if(muscle_id != ''){
    //   //     $.post('/<?php echo ADMIN_URL; ?>day/bindExercise', { muscle_id: muscle_id}, function (result) {
    //   //     $('#listExercise').html(result);
    //   //     });
    //   //  }
    // }

    $('#muscleList').change(function () {

      var muscle_name = $('#muscleList').val();
      //alert(muscle_name);
      $.post('/<?php echo ADMIN_URL; ?>Day/bindExercise', { muscle_name: muscle_name}, function (result) {
      $('#listExercise').html(result);

        });
      if(muscle_name != ''){
        $('#ValueExercise').show();
        }else{
          $('#ValueExercise').hide();
        }
      });


      $('#lnAdd').click(function () {
        var day_name = $('#day_name').val();
        var day_number = $('#day_number').val();
        var week_number = $('#week_number').val();
        var description = $('#description').val();
        var image_type = $('input[name="image_type"]:checked').val();

        var setvalue = $('#setvalue').val();;
        var rep = $('#rep').val();;
        var rest = $('#rest').val();

        var muscle_name = $('#muscleList').val();
        if(image_type != 'rest.png'){
          if(muscle_name != ''){
            if($('input[name="exercise_id"]:checked').val()){
              var exercise = $('input[name="exercise_id"]:checked').val().split(",");
              var exercise_id = exercise[0];
              var exercise_name = exercise[1];
            }else{
              alert('you must choose exercise');
              return;
            }
          }else {
            alert('you should choose muscle and exercise');
            return; // do nothing
          }
        }else{  // image type = REST DAY
          var exercise_id = 0;
          var exercise_name = '';

        }
          $.post('/<?php  echo ADMIN_URL; ?>Day/ajaxadd/<?php echo $program_id; ?>', { setvalue: setvalue, rep: rep, rest: rest, exercise_id: exercise_id, exercise_name: exercise_name,
            day_name: day_name, day_number: day_number, week_number: week_number, image_type:image_type, description: description}, function (result) {

          $('#setvalue').val('');
          $('#rep').val('');
          $('#rest').val('');
          alert('adding success ! result: ' + result);
        });
      });
</script>

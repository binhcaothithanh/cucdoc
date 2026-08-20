<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit day</h1>
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
                            Edit day_exercise thành công
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
                                <input type="text" class="form-control" id="day_name" name="day_name" placeholder="Enter day name" value="<?php echo $day['day_name']; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="day_number">day number</label>
                                <input type="text" class="form-control" id="day_number" name="day_number" placeholder="Enter day number" value="<?php echo $day['day_number']; ?>">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="week_number">week number</label>
                                  <input type="text" class="form-control" id="week_number" name="week_number" placeholder="Enter week number" value="<?php echo $day['week_number']; ?>">
                              </div>
                        </div>
                        <div class="box-body">
                          <div class="form-group">
                              <label for="image_type">Image type (of day)</label>
                              <div style=" overflow: scroll; border: 1px dotted red;">
                                <UL>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>strengthtraining.png' style='height: 100px;' />
                                    <input <?php if($day['image_type'] == 'strengthtraining.png'):
                                        echo (' checked ');
                                      endif; ?>  type="radio" id="strengthtraining.png" name="image_type" value="strengthtraining.png">
                                    <label for="strengthtraining.png">Strength training</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>powerworkout.png' style='height: 100px;' />
                                    <input <?php if($day['image_type'] == 'powerworkout.png'):
                                        echo (' checked ');
                                      endif; ?> type="radio" id="powerworkout.png" name="image_type" value="powerworkout.png">
                                    <label for="powerworkout.png">Power Workout</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>upperbodystrength.png' style='height: 100px;' />
                                    <input type="radio"<?php if($day['image_type'] == 'upperbodystrength.png'):
                                        echo (' checked ');
                                      endif; ?>  id="upperbodystrength.png" name="image_type" value="upperbodystrength.png">
                                    <label for="upperbodystrength.png">Upper body Strength</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>powerliftingtraining.png' style='height: 100px;' />
                                    <input type="radio" <?php if($day['image_type'] == 'powerliftingtraining.png'):
                                        echo (' checked ');
                                      endif; ?> id="powerliftingtraining.png" name="image_type" value="powerliftingtraining.png">
                                    <label for="powerliftingtraining.png">Powerlifting Workout</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>rest.png' style='height: 100px;' />
                                    <input type="radio" <?php if($day['image_type'] == 'rest.png'):
                                        echo (' checked ');
                                      endif; ?> id="rest.png" name="image_type" value="rest.png">
                                    <label for="rest.png">Rest</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>leg.png' style='height: 100px;' />
                                    <input type="radio"  <?php if($day['image_type'] == 'leg.png'):
                                        echo (' checked ');
                                      endif; ?>  id="leg.png" name="image_type" value="leg.png">
                                    <label for="leg.png">Leg</label>
                                  </li>
                                  <li>
                                    <img src='<?php echo PATH_PROGRAM_IMAGE ?>chestshoulder.png' style='height: 100px;' />
                                    <input type="radio"  <?php if($day['image_type'] == 'chestshoulder.png'):
                                        echo (' checked ');
                                      endif; ?>  id="chestshoulder.png" name="image_type" value="chestshoulder.png">
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
                                <textarea name="description" class="form-control" rows="10" id="description"><?php echo $day['description']; ?></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                          <a href="/<?php echo ADMIN_URL; ?>day" class="btn btn-primary">Danh sách day_exercise</a>
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
                      <div class="form-group">
                          <label for="exerciseList">Exercise name</label>
                          <div style="height: 300px; overflow: scroll; border: 1px dotted red;">
                            <img src='<?php echo PATH_EXERCISE_IMAGE . $day['image_exercise']; ?>' style='height: 100px;' />
                            <input type="radio" checked id="<?php echo ($day['exercise_id']) ?>" name="exercise_id" value="<?php echo ($day['exercise_id'] . ','. $day['exercise_name']) ?>">
                            <label for="<?php echo ($day['exercise_id']) ?>"><?php echo ($day['exercise_name']) ?></label>
                            <input id="exercise_id" type="text" class="form-control" value="<?php echo($day['exercise_id']); ?>" name="exercise_id" style="display: none" >
                        </div>
                      </div>

                    </div>
                    <div id="ValueExercise" style="display: block">
                      <div class="box-body">
                          <div class="form-group">
                              <label for="setvalue">set-value</label>
                              <input id="setvalue" type="text" class="form-control" name="setvalue" placeholder="Enter set-value number" value="<?php echo ($day['setvalue']) ?>">
                          </div>
                      </div>
                      <div class="box-body">
                          <div class="form-group">
                              <label for="rep">rep</label>
                              <input id="rep" type="text" class="form-control" name="rep" placeholder="Enter rep number" value="<?php echo ($day['rep']) ?>">
                          </div>
                      </div>
                      <div class="box-body">
                          <div class="form-group">
                              <label for="rest">rest</label>
                              <input id="rest" type="text" class="form-control" name="rest" placeholder="Enter rest number" value="<?php echo ($day['rest']) ?>">
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
    $('#muscleList').change(function () {

      var muscle_name = $('#muscleList').val();
      //alert(muscle_name);
      $.post('/<?php echo ADMIN_URL; ?>Day/bindExercise', { muscle_name: muscle_name}, function (result) {
      $('#listExercise').html(result);

        });
      if(muscle_name != ''){
        $('#ValueExercise').show();
        $('#setvalue').val('');
        $('#rep').val('');
        $('#rest').val('');
        }else{
          $('#ValueExercise').hide();
        }
      });

      // $('#lnEditSubmit').click(function () {
      //   var day_name = $('#day_name').val();
      //   var day_number = $('#day_number').val();
      //   var week_number = $('#week_number').val();
      //   var description = $('#description').val();
      //   var image_type = $('#image_type').val();
      //
      //   var set = $('#set').val();;
      //   var rep = $('#rep').val();;
      //   var rest = $('#rest').val();
      //
      //   var muscle_name = $('#muscleList').val();
      //   if(image_type != 'Rest' && muscle_name == '' && $('#exercise_id').val() == ''){
      //       alert('you must choose muscle and exercise');
      //       return;
      //   }
      //
      //   $('#form').submit();
      // });

</script>

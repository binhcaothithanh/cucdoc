<div class="form-group">
    <label for="exerciseList">Exercise name</label>
    <div style="height: 945px; overflow: scroll; border: 1px dotted red;">
    <ul id="muscleList" name="muscleList" >
        <?php
        // var_dump($results);
        // die;
        if(isset($exercises)):
        foreach ($exercises as $exercise) : ?>
            <li value="<?php echo ($exercise['id']) ?>">
              <img src='<?php echo PATH_EXERCISE_IMAGE . $exercise['image']; ?>' style='height: 100px;' />
              <input type="radio" id="<?php echo ($exercise['id']) ?>" name="exercise_id" value="<?php echo ($exercise['id'] . ','. $exercise['exercise_name']) ?>">
              <label for="<?php echo ($exercise['id']) ?>"><?php echo ($exercise['exercise_name']) ?></label>
            </li>
        <?php
        endforeach;
      else:
        ?>
        please choose muscle below.
        <?php
      endif;
        ?>
    </ul>
  </div>
</div>

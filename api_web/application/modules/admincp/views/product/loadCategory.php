<option value=""> -- Danh mục -- </option>
<?php
$category_parents = $categories;

?>
    <option value="<?php echo(CATEGORY_ROOT_ID); ?>"> --- ROOT --- </option>
    <?php foreach($category_parents as $item):
       if(isset($category_parents[$item['id']]) && $item['id'] != CATEGORY_ROOT_ID):
        ?>
        <option <?php echo $cat_id == $item['id'] ? 'selected' : ''; ?> value="<?php echo $item['id']; ?>"><?php echo(PRE_CATEGORY_CHILD . $item['title'] . PRE_CATEGORY_CHILD); ?></option>
        <?php
         if(isset($category_parents[$item['id']]['childs'])):
        foreach($category_parents[$item['id']]['childs'] as $item1):
            ?>
            <option <?php echo $cat_id == $item1['id'] ? 'selected' : ''; ?> value="<?php echo $item1['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item1['title']); ?></option>
            <?php
            if(isset($category_parents[$item1['id']]['childs'])):
            foreach($category_parents[$item1['id']]['childs'] as $item2):
                ?>
                <option <?php echo $cat_id == $item2['id'] ? 'selected' : ''; ?> value="<?php echo $item2['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item2['title']); ?></option>
                <?php
                  if(isset($category_parents[$item2['id']]['childs'])):
                  foreach($category_parents[$item2['id']]['childs'] as $item3):
                    ?>
                    <option <?php echo $cat_id == $item3['id'] ? 'selected' : ''; ?> value="<?php echo $item3['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item3['title']); ?></option>
                    <?php
                      if(isset($category_parents[$item3['id']]['childs'])):
                      foreach($category_parents[$item3['id']]['childs'] as $item4):
                        ?>
                        <option <?php echo $cat_id == $item4['id'] ? 'selected' : ''; ?> value="<?php echo $item4['id']; ?>"><?php echo( PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . PRE_CATEGORY_CHILD . $item4['title']); ?></option>
                        <?php
                      endforeach;
                      unset($category_parents[$item4['id']]);

                   endif;
                   unset($category_parents[$item3['id']]);

                  endforeach;
                endif;

                unset($category_parents[$item2['id']]);
            endforeach;
          endif;
          unset($category_parents[$item1['id']]);
        endforeach;
      endif;

      unset($category_parents[$item['id']]);
      endif;
    endforeach; ?>

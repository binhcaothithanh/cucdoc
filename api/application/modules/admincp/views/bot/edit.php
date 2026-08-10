<div class="content-wrapper">
    <section class="content-header">
        <h1>EDIT Exercise</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>exercise">List exercise</a></li>
            <li class="active">Edit exercise</li>
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
                            cap nhat thành công
                        </div>
                    <?php endif; ?>
                    <?php if ($check_error == 1) : ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="box box-primary box-success">
                        <div class="box-header">
                            <h3 class="box-title">Basic info</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">exercise name</label>
                                <input type="text" name="exercise_name" value="<?php echo $exercise['exercise_name']; ?>" class="form-control" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Level">Level name</label>
                                <select name="level_name" class="form-control">
                                    <option value=""> --- Level list --- </option>
                                    <?php
                                    foreach ($levels as $level) : ?>
                                        <option <?php if ($level['level_name'] == $exercise['level_name']) :
                                                    echo (' selected ');
                                                  
                                                endif; ?> value="<?php echo ($level['level_name']) ?>"><?php echo ($level['level_name']) ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Muscle">Muscle name</label>
                                <select name="muscle_name" class="form-control">
                                    <option value=""> --- muscle list --- </option>
                                    <?php
                                    foreach ($muscles as $muscle) : ?>
                                        <option
                                        <?php if ($muscle['muscle_name'] == $exercise['muscle_name']) :
                                                    echo (' selected ');
                                                endif; ?>
                                        value="<?php echo ($muscle['muscle_name']) ?>"><?php echo ($muscle['muscle_name']) ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="topic_name">Topic name</label>
                                <select name="topic_name" class="form-control">
                                    <option value=""> --- topic list --- </option>
                                    <?php
                                    foreach ($topics as $topic) : ?>
                                        <option
                                        <?php if ($topic['topic_name'] == $exercise['topic_name']) :
                                                    echo (' selected ');
                                                endif; ?>
                                        value="<?php echo ($topic['topic_name']) ?>"><?php echo ($topic['topic_name']) ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image1">image1 name</label>
                                <input type="text" class="form-control" name="image1" value="<?php echo $exercise['image1']; ?>" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image2">image2 name</label>
                                <input type="text" class="form-control" name="image2" value="<?php echo $exercise['image2']; ?>" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image3">image3 name</label>
                                <input type="text" class="form-control" name="image3" value="<?php echo $exercise['image3']; ?>" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fullname">Description</label>
                                <textarea name="description" class="form-control" id="description"><?php echo $exercise['description']; ?></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

</div>

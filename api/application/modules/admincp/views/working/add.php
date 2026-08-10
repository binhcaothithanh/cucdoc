
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm Exercise</h1>
        <ol class="breadcrumb">
            <li><a href="/<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/<?php echo ADMIN_URL; ?>exercise">Danh sách exercise</a></li>
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
                            Thêm exercise thành công
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
                                <label for="exercise_name">exercise name</label>
                                <input type="text" class="form-control" name="exercise_name" placeholder="Enter exercise name" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="muscle_name">Muscle name</label>
                                <select name="muscle_name" class="form-control">
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

                        <div class="box-body">
                            <div class="form-group">
                                <label for="image">Diffifulty name</label>
                                <input type="text" class="form-control" name="difficulty" placeholder="Enter difficulty" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image">Equipment name</label>
                                <input type="text" class="form-control" name="equipment" placeholder="Enter Equipment" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="image">image name</label>
                                <input type="text" class="form-control" name="image" placeholder="Enter exercise image" />
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description"></textarea>
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

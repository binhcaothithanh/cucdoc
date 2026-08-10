<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/dev.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/jquery.Jcrop.css" rel="stylesheet" type="text/css" />
        <link href="/assets/admin/css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" />

        <!-- calender -->
        <link href="/assets/admin/css/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

        <script src="/assets/admin/js/jquery-1.11.3.min.js"></script>
        <script src="/assets/admin/js/jquery-ui.min.js"></script>
        <script src="/assets/admin/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="/assets/admin/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/assets/admin/ckfinder/ckfinder.js"></script>
        <script src="/assets/admin/js/jquery.Jcrop.min.js"></script>

        <script>var pre2 = '<?php echo $pre2; ?>';</script>
        <script src="/assets/admin/js/main.js" type="text/javascript"></script>
        <script src="/assets/admin/js/crop.js" type="text/javascript"></script>
        <script src="/assets/admin/js/auto.js" type="text/javascript"></script>
        <script src="/assets/admin/js/linktudong.js" type="text/javascript"></script>
        <script src="/assets/admin/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
        <script src="/assets/admin/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

    </head>
    <body class="skin-blue sidebar-mini">
        <div id="dialog"></div>
        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->
                <a href="/<?php echo ADMIN_URL; ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Z</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin</b> <?php echo $username; ?></span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/assets/admin/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $fullname; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="/assets/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $fullname; ?>
                                            <small>Member since Nov. 2016</small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/<?php echo ADMIN_URL; ?>auth/change_password" class="btn btn-default btn-flat">Change Password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/<?php echo ADMIN_URL; ?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->

                        </ul>
                    </div>

                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel   -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="/assets/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $username; ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <ul class="sidebar-menu" <?php // if ($user['role'] != 'admin'): echo('style="display:none"'); endif; ?>  >
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview <?php echo $pre1 == 'order' ? 'active' : ''; ?>"
                          <?php if($user['role'] != 'admin'):
                            if(strpos($user['roles'], 'order') === false ):
                              echo ('style="display:none"');
                            endif;
                           endif; ?>
                          >
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Quản lý đơn hàng</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="order" action="order"><a href="/<?php echo ADMIN_URL; ?>order"><i class="fa fa-circle-o"></i> Danh sách đơn hàng</a></li>
                                <!-- <li class="export_shipping" action="export_shipping"><a href="/<?php echo ADMIN_URL; ?>export_shipping"><i class="fa fa-circle-o"></i> In đơn hàng</a></li>
                                <li class="export_shipping" action="re_print"><a href="/<?php echo ADMIN_URL; ?>export_shipping/re_print"><i class="fa fa-circle-o"></i> In lại đơn hàng</a></li>
                                <li class="update_shipping" action="update_shipping"><a href="/<?php echo ADMIN_URL; ?>update_shipping"><i class="fa fa-circle-o"></i> Cập nhật vận chuyển</a></li>
                                <li class="update_shipping" action="export_excel"><a href="/<?php echo ADMIN_URL; ?>update_shipping/export_excel"><i class="fa fa-circle-o"></i> Xuất excel</a></li> -->
                                <!-- <li class="update_shipping" action="update_office_code"><a href="/<?php echo ADMIN_URL; ?>update_shipping/update_office_code"><i class="fa fa-circle-o"></i> Cập nhật mã bưu điện</a></li>
                                <li class="update_shipping" action="update_order_success"><a href="/<?php echo ADMIN_URL; ?>update_shipping/update_order_success"><i class="fa fa-circle-o"></i> Đơn hàng đã nhận tiền</a></li>
                                <li class="update_shipping" action="update_order_fail"><a href="/<?php echo ADMIN_URL; ?>update_shipping/update_order_fail"><i class="fa fa-circle-o"></i> Hoàn trả đơn hàng</a></li> -->
                            </ul>
                        </li>

                        <li class="treeview <?php echo $pre1 == 'project' ? 'active' : ''; ?>"
                          <?php if($user['role'] != 'admin'):
                            if(strpos($user['roles'], 'project') === false ):
                              echo ('style="display:none"');
                            endif;
                           endif; ?>
                          >
                            <!-- <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Quản lý dự án</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="project" action="project"><a href="/<?php echo ADMIN_URL; ?>project"><i class="fa fa-circle-o"></i> Danh sách dự án</a></li>
                            </ul> -->
                        </li>

                        <li class="treeview <?php echo $pre1 == 'product' ? 'active' : ''; ?>"

                          >
                            <a href="#">
                                <i class="fa fa-database"></i>
                                <span>Quản lý sản phẩm</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'product') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="product" action="product"><a href="/<?php echo ADMIN_URL; ?>product"><i class="fa fa-circle-o"></i> Danh sách sản phẩm</a></li>
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'attribute_type') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="attribute_type" action="attribute_type"><a href="/<?php echo ADMIN_URL; ?>attribute_type"><i class="fa fa-circle-o"></i> Danh sách loại thuộc tính</a></li>
                                 <li
                                 <?php if($user['role'] != 'admin'):
                                  if(strpos($user['roles'], 'product') === false ):
                                    echo ('style="display:none"');
                                  endif;
                                 endif; ?>
                                  class="product" action="addproduct"><a href="/<?php echo ADMIN_URL; ?>product/add"><i class="fa fa-circle-o"></i> Thêm sản phẩm</a></li>

                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'category') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                class="category" action="category"><a href="/<?php echo ADMIN_URL; ?>category"><i class="fa fa-circle-o"></i> Danh sách thể loại</a></li>
                            </ul>
                        </li>
                        <!-- <li class="treeview <?php echo $pre1 == 'report' ? 'active' : ''; ?>"
                          <?php if($user['role'] != 'admin'):
                           if(strpos($user['roles'], 'report') === false ):
                             echo ('style="display:none"');
                           endif;
                          endif; ?>
                          > -->
                            <!-- <a href="#">
                                <i class="fa fa-cog"></i>
                                <span>Thống kê</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li  class="report" action="traffic"><a href="/<?php echo ADMIN_URL; ?>report/traffic"><i class="fa fa-circle-o"></i> Traffic</a></li>
                                <li  class="report" action="report"><a href="/<?php echo ADMIN_URL; ?>report"><i class="fa fa-circle-o"></i> Doanh thu</a></li>
                            </ul> -->
                        <!-- </li> -->
                        <li class="treeview <?php echo $pre1 == 'other' ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span>Quản lý Khác</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'admin') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="admin" action="admin"><a href="/<?php echo ADMIN_URL; ?>admin"><i class="fa fa-circle-o"></i> Danh sách quản trị</a></li>
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'page') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="page" action="page"><a href="/<?php echo ADMIN_URL; ?>page"><i class="fa fa-circle-o"></i> Danh sách trang</a></li>
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'gallery') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="gallery" action="gallery"><a href="/<?php echo ADMIN_URL; ?>gallery"><i class="fa fa-circle-o"></i> Danh sách gallery</a></li>
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'homeinfo') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="homeinfo" action="homeinfo"><a href="/<?php echo ADMIN_URL; ?>homeinfo"><i class="fa fa-circle-o"></i> SEO HOME</a></li>
                                <li
                                <?php if($user['role'] != 'admin'):
                                 if(strpos($user['roles'], 'cache') === false ):
                                   echo ('style="display:none"');
                                 endif;
                                endif; ?>
                                 class="cache" action="cache"><a href="/<?php echo ADMIN_URL; ?>cache"><i class="fa fa-circle-o"></i> Xóa Cache</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <?php if ($user['role'] == 'manager'): ?>
                <style>
                    .treeview .treeview-menu li{display: none;}
                    <?php echo '.' . str_replace(',', ',.', $user['roles']) ?>{display: block !important;}
                </style>
                <script>
                $("<?php echo '.' . str_replace(',', ',.', $user['roles']) ?>").addClass('has_permisstion');
                $(".treeview").each(function () {
                    if ($('li.has_permisstion', this).length == 0) {
                        $(this).remove();
                    }
                });
                </script>
            <?php endif; ?>
            <div class="box" style="position: relative;">
                <div style="display: none;" id="loading_content" class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <?php echo $content_block; ?>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 3.0
                </div>
                <strong>Copyright &copy; 2015-2016 <a href="http://shopdaophuot.org">S-D-P</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- jQuery 2.1.4 -->
        <script src="/assets/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src='/assets/admin/plugins/fastclick/fastclick.min.js'></script>
        <script src="/assets/admin/js/app.min.js" type="text/javascript"></script>
        <script>
//            window.history.pushState("", "", "/new-url");
            $('.format_number').autoNumeric('init', {aPad: false});
            $('form').submit(function () {
                $('input.format_number').each(function () {
                    $(this).val($(this).autoNumeric('get'));
                });
            });
        </script>
    </body>
</html>

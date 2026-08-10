<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $seo['seo_title']; ?> - VuaSung.com</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="AUTHOR" content="VuaSung.com"/> 
        <meta name="description" content="<?php echo $seo['meta_description']; ?>" />
        <meta name="keywords" content="<?php echo $seo['meta_keyword']; ?>" />	
        <link href="/assets/user/images/favi.png" rel="shortcut icon" />
        <!--FB-->
        <meta property="og:url" content="<?php echo $current_url; ?>" />
        <meta property="og:type"   content="website" />
        <meta property="og:site_name" content="Shopdaophuot.com"/>
        <meta property="og:title" content="<?php echo $seo['seo_title']; ?> - ShopDaoPhuot.com" />
        <meta property="og:description" content="<?php echo $seo['meta_description']; ?>" />
        <meta property="og:image" content="<?php echo $url_image; ?>"/>

        <!--<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>-->
        <link href="/assets/user/css/form.css?t=22" rel="stylesheet" type="text/css">
        <link href="/assets/user/css/style.css?t=32" rel="stylesheet" type="text/css">

        <script src="/assets/user/js/jquery-1.12.1.min.js"></script>      
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="top-bar">
                    <ul class="top-bar-right">
                        <li><a href="/gio-hang.html">Giỏ hàng</a></li>                      
                        <li class="no-bdr">
                            <a href="/gio-hang.html">Tổng Tiền : <?php echo intval(substr($total_money, 0, strlen($total_money) - 3)); ?>k</a>
                        </li>
                    </ul> 
                </div>
                <div class="navigation-bar tas-main-nav">
                    <div id="mega-menu" class="menuFlex">
                        <select class="menu_moblie">
                            <option value="/">Trang chủ</option>
                            <?php foreach ($categories as $item): ?>
                                <option <?php echo @$cat['id'] == $item['id'] ? 'selected' : ''; ?> value="/danh-muc/<?php echo $item['alias']; ?>"><?php echo $item['title']; ?></option>
                                <?php foreach ($item['childs'] as $k => $child): ?>
                                    <option <?php echo @$cat['id'] == $child['id'] ? 'selected' : ''; ?>  value="/danh-muc/<?php echo $child['alias']; ?>"><?php echo PRE_CATEGORY_CHILD . $child['title']; ?></option>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </select>
                        <ul>
                         <li class="no-bdr"><a href="/">Trang chủ</a></li>
                            <?php foreach ($categories as $item): ?>
                                <li>
                                    <a id="main-link4" href="/danh-muc/<?php echo $item['alias']; ?>"  class=""><?php echo $item['title']; ?></a>
                                    <div class="sub_menu">
                                        <div class="row">
                                            <?php foreach ($item['childs'] as $k => $child): ?>
                                                <?php echo $k != 0 && $k % 2 == 0 ? '</div><div class="row">' : ''; ?>
                                                <ul><li><a class="dropheading" href="/danh-muc/<?php echo $child['alias']; ?>"><?php echo $child['title']; ?></a> 	</li></ul>                                             
                                            <?php endforeach; ?>       
                                        </div>
                                    </div>
                                </li>   
                            <?php endforeach; ?>
                        </ul>
									<div class="header-right">
	                      			  <form  method="get" action="/tim-kiem" >
	                            		  <span class="button-wrapper-tas quick-search-button-wrapper">
	                                <input type="submit" class="quick-search-button" value="" style="background-image: url(/assets/user/images/quick-search-button.gif);background-color:#98803a;background-position:4px;cursor: pointer; background-repeat: no-repeat; border: solid 0px #000000; width: 30px; height: 29px;" />

	                            </span>                           
	                            <input type="text" name="q" size="21" placeholder="tìm kiếm"  style="font: 13px/24px Oswald, Helvetica, Arial, sans-serif;
    color: white;
    display: block;
    float: left;
    padding: 0 12px 3px;
    border-left: dotted 1px #575757;
    text-transform: uppercase;">  
                    
	                        </form>
						</div>
                    </div>
                    <div style="clear:left"></div>
                </div>

                <div class="content">
                    <?php echo $content_block; ?>
                </div>
            </div>

            <div class="footer-area">
                <div class="container">
                    <div class="footer-menu" style="padding-left: 0;">
                        <ul>
                            <li>
                                <h3>Dịch vụ</h3>
                            </li>
                            <li><a href="/thanh-toan-giao-nhan.html">Thanh toán giao nhận</a></li>
                        </ul>
                    </div>
                    <div class="footer-menu">
                        <ul>
                            <li>
                                <h3>Thông tin trang</h3>
                            </li>
                            <li><a href="/gioi-thieu.html">Giới Thiệu</a></li>     
                            <li><a href="/lien-he.html">Liên hệ</a></li>     
                        </ul>
                    </div>
                    <div class="footer-address"> 
                        Địa chỉ : 123 Ngõ Tuổi trẻ, Hoàng Quốc Việt, Q Cầu Giấy, Hà Nội<br>                        
                        Sale  : 0932.796.716<br>               
                    </div>                  
                    <div class="social-icons">
                        <a href="https://www.facebook.com/vuasung.com2020" target="_blank">
                            <img src="/assets/upload/gallery/Tips-Fanpage-Facebook-300x104.png" height="44" alt="Find us on Facebook" border="0">
                        </a>

                    </div>
                </div>
            </div>

        </div>
		        <script src="/assets/user/js/main.js?t=111"></script>
	
    </body>
</html>
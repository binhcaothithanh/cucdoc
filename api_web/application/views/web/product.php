<div id="product-page-body">
    <div class="page-navigation">
        <div id="idBreadcrumbsTop" style="visibility: visible;">
            <div class="breadcrumb">
                <ul>
                    <li><a href="/" class="ajs-bc-home" target="_self"><strong>Home</strong>&nbsp;&gt;</a> </li>
                    <?php if (!empty($cat_parent)): ?>
                        <li><a href="/danh-muc/<?php echo $cat_parent['alias'] ?>" class="ajs-bc-home" target="_self"><strong><?php echo $cat_parent['title'] ?></strong>&nbsp;&gt;</a> </li>
                    <?php endif; ?>
                    <li><a href="/danh-muc/<?php echo $cat['alias'] ?>" class="ajs-bc-home" target="_self"><strong><?php echo $cat['title'] ?></strong>&nbsp;&gt;</a> </li>
                </ul>
            </div>
        </div>

    </div>
    <actinic:section><br />
        <h1><?php echo $product['title']; ?></h1>
        <?php $folder = '/assets/upload/product/' . $product['folder'] . '/'; ?>
        <?php if ($is_mobile): ?>
            <link href="/assets/user/css/jquery.bxslider.css" rel="stylesheet" type="text/css"/>
            <script src="/assets/user/js/jquery.bxslider.min.js"></script>
            <div class="slideshow">
                <div class="bx-wrapper">
                    <div id="slider"  class="nivoSlider" style="position: relative;">
                      <?php if(strpos($product['image'], 'http') === false): ?>
                        <?php foreach ($list_image as $k => $v): ?>
                            <div><img border="0" class="mz_icon" src="<?php echo $folder . 'goc/' . $v['name']; ?>" alt="<?php echo $product['title'] . ' - hình ' . ($k + 1) ?> "></div>
                        <?php endforeach; ?>
                      <?php else:
                        $list_image = explode(',', $product['image']);
                         ?>
                        <?php foreach ($list_image as $eachImage): ?>
                            <div><img border="0" class="mz_icon" src="<?php echo $eachImage; ?>" alt=""></div>
                        <?php endforeach; ?>
                      <?php endif; ?>

                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(window).load(function () {
                    $('#slider').bxSlider({
                        minSlides: 0,
                        maxSlides: 1,
                    });
                });
            </script>
        <?php else: ?>
            <div class="product-details-image">
                <table class="mzp-ptab mzp-tab-below">
                    <tbody>
                        <tr>
                            <td class="mzp-img-below product_album">
                                <?php if(strpos($product['image'], 'http') === false): ?>
                                <a rel="prettyPhoto" href="<?php echo $folder . 'goc/' . @$list_image[0]['name']; ?>">
                                    <img src="<?php echo $folder . 'goc/' . @$list_image[0]['name']; ?>"  border="0" width="280"  alt="<?php echo $product['title']; ?>" style="opacity: 1;">
                                </a>
                              <?php else:
                                $list_image = explode(',', $product['image']);
                                 ?>
                                <a rel="prettyPhoto" href="<?php echo $list_image[0]; ?>">
                                    <img src="<?php echo $list_image[0]; ?>"  border="0" width="280" height="280"  alt="<?php echo $product['title']; ?>" style="opacity: 1;">
                                </a>
                              <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="mzp-ico-below thumb_product_album" align="center">
                                <?php if (strpos($product['image'], 'http') === false && count($list_image) > 1): ?>
                                    <br><p style="border-top: 1px dashed #bebebe;">More Images</p><br>
                                    <?php foreach ($list_image as $k => $v): ?>
                                        <a href="#" title="<?php echo $product['title'] . ' - hình ' . ($k + 1) ?> " class="MagicThumb-swap" style="outline: 0px; display: inline-block;">
                                            <img border="0" class="mz_icon" width="80" height="80" src="<?php echo $folder . 'goc/' . $v['name']; ?>" alt="<?php echo $product['title'] . ' - hình ' . ($k + 1) ?> ">
                                        </a>
                                    <?php endforeach; ?>
                                <?php else:
                                  $list_image = explode(',', $product['image']);  ?>
                                  <br><p style="border-top: 1px dashed #bebebe;">More Images</p><br>
                                  <?php foreach ($list_image as $eachImage): ?>
                                      <a href="#" title="<?php echo $product['title']  ?> " class="MagicThumb-swap" style="outline: 0px; display: inline-block;">
                                          <img border="0" class="mz_icon" width="80" height="80" src="<?php echo $eachImage ?>" alt="<?php echo $product['title']?> ">
                                      </a>
                                <?php endforeach;
                               endif; ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <div class="product-details-text">
            <actinic:prices  retail_price_prompt="Price:">
                <div id="id1264StaticPrice" style="display: inline"> <br />
                    <span class="product-price">
                      <?php if ($product['price'] > 0): ?>
                        <div class="product-details-price">Giá: <span class="new-price"><?php echo substr($product['price'], 0, strlen($product['price']) - 3); ?>k</span></div>
                      <?php else: ?>
                        <div class="product-details-price">Giá: <span class="new-price">Liên Hệ</span></div>
                      <?php endif; ?>
                        <?php
                        echo $product['price_compare'] ?
                                '<div class="product-details-old-price">Giá cũ ' . substr($product['price_compare'], 0, strlen($product['price_compare']) - 3) .
                                'k - Giảm ' . (ceil(($product['price_compare'] - $product['price']) * 100 / $product['price_compare'])) . '%</div>' : '';
                        ?>
                    </span>

                </div>
            </actinic:prices>

            <?php
            $check_quantity = -1;
            if ($product['count']) {
                echo '<div class="stock-info"><span class="in-stock">Còn Hàng | Có thể đặt mua</span></div>';
                $check_quantity = 1;
            } else {
                $more_text = ' | Không thể đặt hàng';
                if ($product['can_buy'] == 1) {
                    $check_quantity = 0;
                    $more_text = ' | Có thể đặt mua hàng <br /> <br /><font size="1px" color="green">(sau khi bạn đặt - khi nào nhập hàng về chúng tôi sẽ alo)</font>';
                }
                echo '<div class="stock-info"><span class="out-of-stock">Hết hàng' . $more_text . '</span> </div>';
            }
            ?>
            <div class="action-box">
                <form action="/order/add_product" method="post">
                    <div id="idVars1264">
                        <div class="attribute-list product-details-options">
                            <input name="product_id" type="hidden" value="<?php echo $product['id']; ?>"/>
                            <input name="submit_type" type="hidden" value="direct"/>
                            <table>
                                <tbody>
                                    <tr>
                                        <td><label><label>Chọn mẫu</label></label></td>
                                        <td>
                                            <select  name="sku_id" style="min-width: 100px;float: left;height: 25px;" class="form_input_general ajs-attr">
                                                <?php foreach ($skus as $item): ?>
                                                    <?php $item['count'] = $check_quantity == 1 ? $item['count'] : 10;
                                                    if(strpos($item['image'], 'http') === false):
                                                    ?>
                                                    <option img="<?php echo $folder . $item['image']; ?>" count="<?php echo $item['count'] ?>" value="<?php echo $item['id']; ?>"><?php echo $item['color'] . ($item['size'] ? ' - ' . $item['size'] : '') ?></option>
                                                  <?php else: ?>
                                                    <option img="<?php echo explode(',', $item['image'])[0]; ?>" count="<?php echo $item['count'] ?>" value="<?php echo $item['id']; ?>"><?php echo $item['color'] . ($item['size'] ? ' - ' . $item['size'] : '') ?></option>
                                                  <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td rowspan="2">
                                            <img width="100px"  class="thumb_sku" />
                                        </td>
                                    </tr>
                                    <?php if ($check_quantity != -1): ?>
                                        <tr>
                                            <td><label><label>Số lượng</label></label></td>
                                            <td>
                                                <select  name="quantity" style="min-width: 100px;height: 25px;" class="form_input_general ajs-attr"></select>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <?php
                    if($product['price'] > 0):
                     if ($check_quantity != -1): ?>
                        <div class="tas-cart-button-holder">
                            <span  class="ActinicRTS">
                                <?php
                                if ($product['count'] < 1) { // het hang van dat hang duoc
                                    echo('<input style="margin-top: 7px;" value="Đặt trước" name="submit" type="submit" class="tas-button tas-red-button" />');
                                } else {

                                    echo('<input style="margin-top: 7px;" value="Mua ngay" name="submit" type="submit" class="tas-button tas-big-button" />');
                                }
                                ?>
                            </span>
                        </div>
                    <?php endif;
                  else: ?>
                  <div class="tas-cart-button-holder">
                      <span  class="ActinicRTS">
                          <?php
                            echo('<a href="/huong-dan-mua-ccht.html" class="tas-button tas-red-button">Hướng Dẫn Mua</a>');
                          ?>
                      </span>
                  </div>

                    <?php
                  endif;
                    ?>
                </form>
            </div>

            <div class="feefo-small">
                <div class="feefoproductlogo">
                    <a>
                        <img src="/assets/user/images/feefologo_1.png" border="0"  >
                    </a>
                </div>
            </div>
            <div id="fb-root"></div>
            <script>
                window.fbAsyncInit = function () {
                    FB.init({
                        appId: '1762237504010192',
                        xfbml: true,
                        version: 'v2.3'
                    });
                };

                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="tab-area">
                <div class="tab-contents-here">
                        <div style="display: block;">
                            <div class="fb-comments" data-href="<?php echo $current_url; ?>" data-width="100%" data-num-posts="10"></div>
                        </div>
                </div>
            </div>
        </div>
        <div>
          <div style="display: block; clear:">
              <?php echo $product['content']; ?>
          </div>
        </div>
        <div class="product-promo-list-heading">
            <h2>Sản phẩm cùng loại:</h2>
        </div>
        <div class="product-promo-list">
            <?php foreach ($other_products as $item): ?>
                <div class="tas-product-summary">
                    <div class="product-corner"></div>
                    <div class="tas-product-thumbnail">
                        <a href="/san-pham/<?php echo $item['alias'] . '-' . $item['id'] . '.html'; ?>">
                          <?php if(strpos($item['image'], 'http') === false): ?>
                            <img src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['image']; ?>"  border="0" width="100%" title="<?php echo $item['title']; ?>" alt="<?php echo $item['title']; ?>">
                          <?php else: ?>
                            <img src="<?php echo explode(',', $item['image'])[0]; ?>"  border="0" width="100%" title="<?php echo $item['title']; ?>" alt="<?php echo $item['title']; ?>">
                          <?php endif; ?>

                        </a>
                    </div>
                    <h3><a href="/san-pham/<?php echo $item['alias'] . '-' . $item['id'] . '.html'; ?>"><?php echo $item['title']; ?></a></h3>
                    <div class="tas-product-summary-price">
                      <?php if($product['price'] > 0): ?>
                        <span class="product-price"><strong><?php echo substr($item['price'], 0, strlen($item['price']) - 3); ?>k<sup></sup></strong></span>
                        <span class="old_price"><?php echo $item['price_compare'] ? substr($item['price_compare'], 0, strlen($item['price_compare']) - 3) . 'k' : ''; ?></span>
                      <?php else:?>
                        <span class="product-price"><strong>Giá: Liên Hệ<sup></sup></strong></span>
                      <?php endif; ?>
                        <div style="clear: both;"></div>
                    </div>


                      <?php
                      if($item['price'] > 0):
                      if ($item['count'] == 0 && $item['can_buy'] == 0): ?>
					 <input type="submit" value="Hết hàng" style="cursor: default" class="tas-red-button buy-now">
			<?php else:
						if ($item['count'] > 0):
			?>
                		<input type="submit" value="Mua ngay" onclick="buy_now(<?php echo $item['id']; ?>)" class="tas-button buy-now">
            <?php
            				else: ?>

                		<input type="submit" value="Hết (đặt trước)" onclick="buy_now(<?php echo $item['id']; ?>)" class="tas-order-button buy-now">
<?php            				endif;
                 endif;
               else:  // price = 0 CCHT ?>
               <a href="/huong-dan-mua-ccht.html" class="tas-button buy-now">Hướng dẫn mua</a>
             <?php endif; ?>
                	</div>
            		<?php endforeach; ?>

        </div>
    </actinic:section>
</form>
</div>
<style>
iframe{
  width: 100% !important;
}
</style>
<link href="/assets/user/css/prettyPhoto.css" rel="stylesheet" type="text/css">
<script src="/assets/user/js/jquery.prettyPhoto.js"></script>
<script>
                            if ($(".thumb_sku").length > 0) {
                                $('select[name="sku_id"]').change(function () {
                                    var option_selected = $('select[name="sku_id"] option:selected');
                                    $(".thumb_sku").attr('src', $(option_selected).attr('img'));
                                    var count = $(option_selected).attr('count');

                                    var option_html = '';
                                    for (var i = 1; i <= count; i++) {
                                        option_html += '<option>' + i + '</option>';
                                    }

                                    $('select[name="quantity"]').html(option_html);
                                });
                                $('select[name="sku_id"]').change();
                                $('#custom-tabs li').click(function () {
                                    if (!$('a', this).hasClass('selected')) {
                                        $('#custom-tabs li a').removeClass('selected');
                                        $('a', this).addClass('selected');
                                        $('.tab-contents-here .tabcontent').hide();
                                        $('.tab-contents-here .tabcontent:nth-child(' + ($(this).index() + 1) + ')').fadeIn();
                                        console.log($('a', this).index());
                                    }
                                });
                            }
                            $("a[rel^='prettyPhoto']").prettyPhoto();
                            $('.thumb_product_album a:nth-child(4)').addClass('active');
                            $('.thumb_product_album a').click(function () {
                                if (!$(this).hasClass('active')) {
                                    var _this = this;
                                    var src = $('img', this).attr('src');
                                    $('.product_album a').attr('href', src);
                                    $('.product_album a img').fadeOut(100, function () {
                                        $('.product_album a img').attr('src', src);
                                        $('.product_album a img').fadeIn(300);
                                        $('.thumb_product_album a').removeClass('active');
                                        $(_this).addClass('active');
                                    });
                                }


                                return false;
                            });
</script>

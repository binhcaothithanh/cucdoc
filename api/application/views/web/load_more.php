
<?php foreach ($products as $item): ?>
    <?php
    $href = '/san-pham/' . $item['alias'] . '-' . $item['id'] . '.html';
    $image_status = $item['price_compare'] ? 'sales-cor.png' : @$map_product_status[$item['product_status']];
    $img_first = explode(',', $item['image'])[0];

    ?>
    <div class="tas-product-summary">
        <div class="product-corner">
            <?php
            echo $image_status ? ' <img src="/assets/user/images/' . $image_status . '" width="75" height="75" alt="' . $item['title'] . '">' : '';
            ?>
        </div>
        <div class="tas-product-thumbnail">
            <a href="<?php echo $href; ?>">

                <!-- <img src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['image']; ?>"  border="0" width="100%" title="<?php echo $item['title']; ?>" alt="<?php echo $item['title']; ?>">
                -->
                <img src="<?php echo $img_first; ?>"  border="0" width="100%" title="<?php echo $item['title']; ?>" alt="<?php echo $item['title']; ?>">

            </a>

        </div>
        <h3><a href="<?php echo $href; ?>"><?php echo $item['title']; ?></a></h3>
        <div class="tas-product-summary-price">
            <span class="product-price"><strong><?php echo substr($item['price'], 0, strlen($item['price']) - 3); ?>k<sup></sup></strong></span>
            <span class="old_price"><?php echo $item['price_compare'] ? substr($item['price_compare'], 0, strlen($item['price_compare']) - 3) . 'k' : ''; ?></span>
            <div style="clear: both;"></div>
        </div>

            <?php if ($item['count'] == 0 && $item['can_buy'] == 0): ?>
					 <input type="submit" value="Hết hàng" style="cursor: default" class="tas-red-button buy-now">
			<?php else:
						if ($item['count'] > 0):
			?>
                		<input type="submit" value="Mua ngay" onclick="buy_now(<?php echo $item['id']; ?>)" class="tas-button buy-now">
            <?php
            				else: ?>

                		<input type="submit" value="Hết (đặt trước)" onclick="buy_now(<?php echo $item['id']; ?>)" class="tas-order-button buy-now">
<?php            				endif;
                 endif; ?>
        </div>
<?php endforeach; ?>

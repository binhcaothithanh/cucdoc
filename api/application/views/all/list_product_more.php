<?php foreach ($products as $item): ?>
    <li>
        <div class="item">
            <a href="/san-pham/<?php echo $item['alias'] . '-' . $item['id'] . '.html'; ?>">
                <img src="/assets/upload/product/<?php echo $item['folder'] . '/' . $item['image']; ?>"/>
            </a>
            <div class="info">
                <h2><a href="/san-pham/<?php echo $item['alias'] . '-' . $item['id'] . '.html'; ?>"><?php echo $item['title']; ?></a></h2>
                <div class="price">
                    <span class="price_new"><?php echo number_format($item['price']); ?></span>
                    <?php echo $item['price_compare'] ? '<span class="price_old">' . number_format($item['price_compare']) . '</span>' : ''; ?>
                </div>
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
    </li>
<?php endforeach; ?>  

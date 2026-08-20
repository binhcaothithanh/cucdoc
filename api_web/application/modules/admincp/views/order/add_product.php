<tr product_id="<?php echo $product['id']; ?>" id="<?php echo $sku_order_id; ?>">
    <td>
        <a href="javascript:void(0)" onclick="del_product(<?php echo $sku_order_id; ?>, this)" class="delete-cart-item" title="Xóa sản phẩm này?">&nbsp;</a>
        <img src="/assets/upload/product/<?php echo $product['folder'] . '/' . $product['image']; ?>" alt="" width="50">
        <a target="_bank" href="/san-pham/<?php echo $product['alias'] . '-' . $product['id'].'.html'; ?>"><?php echo $product['title']; ?></a>
    </td>
    <td>
        <select style="width: auto;" class="attribute">
            <?php foreach ($skus as $item): ?>
                <option price="<?php echo $product['price']; ?>" value="<?php echo $item['id']; ?>"><?php echo ($item['size'] ? $item['size'] . ' / ' : '') . $item['color'] ?></option> 
            <?php endforeach; ?>                                                        
        </select>
    </td>
    <td class="price" rel="<?php echo $product['price']; ?>"><?php echo number_format($product['price']); ?></td>                        
    <td>
        <input class="ddl_quan valid format_number" value="1">                                                                                   
    </td>
    <td class="price_final price"></td>
</tr>
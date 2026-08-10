<?php

// display all error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



//  get product_status + all image + infors:

  $linkfull = 'https://bisu.vn/01-vien-pin-sac-eneloop-panasonic-aaa-pro-mau-den-phien-ban-noi-dia-nhat-ban-min-930-mah-500-lan-sac-dien-ap-12v-15v-p3384016.html';
  $fullPage = file_get_contents($linkfull);
  if(strpos($fullPage, 'hết hàng!' !== false){
    // het hang
    $product_status = 0;
  }else {
    $product_status = 1;
  }



  $product_des_prefix = 'swiper-tabs description"';
  $product_des_prefix_end = '<div class="swiper-tabs description product-detail-tab">';
  $product_des = substr($each_product, strpos($each_product, $product_id_prefix) + strlen($product_id_prefix), strpos($each_product, $product_id_prefix_end) - (strpos($each_product, $product_id_prefix) + strlen($product_id_prefix)));



/*  get all products in all pagging:
    // code get list cat:
    $linkfull = 'https://bisu.vn/victorinox-pc73823.html';
    $fullPage = file_get_contents($linkfull);

    // get paging total;
    if(strpos($fullPage, 'paging-last')){
      $total_page = strpos($fullPage, 'paging-last');
      $tmpPage = substr($fullPage, strpos($fullPage, 'paging-last'));
      $findtop = '?page=';
      $findlast = '">';
      $page = substr($tmpPage, strpos($tmpPage, $findtop) + strlen($findtop), strpos($tmpPage, $findlast) - (strpos($tmpPage, $findtop) + strlen($findtop))) ;
    }else{ // 1 page only
      $page = 1;
    }
    // ---------------- product can get: ----------------
    //  product_id;
    //  name
    //  prize
    //  image link
    //
    $j = 0;
    $products = array();
    for($i = 1; $i <= $page; $i++){
      $link_producs_page = $linkfull . '?page=' . $i;
      if($i != 1){
        $fullPage = file_get_contents($link_producs_page);
      }
      $prefix_first_product = 'product-list filter products';
      $prefix_last_product = 'content_sortPagiBar pagi';
      $prefix_each_product = '</li>';



      // Product Zoone:
      $fullPage = substr($fullPage, strpos($fullPage, $prefix_first_product), strpos($fullPage, $prefix_last_product) - strpos($fullPage, $prefix_first_product));
      while(strpos($fullPage, $prefix_each_product) !== false){
        // getting product infor:
        // ---------------- product can get: ----------------
        //  product_id;
        //  name
        //  prize
        //  image link
        //  status product
        //
        $each_product = substr($fullPage,0, strpos($fullPage, $prefix_each_product) + 400) ;

        $product_id_prefix = 'data-id="';
        $product_id_prefix_end = '" data-storeId';
        $product_id = substr($each_product, strpos($each_product, $product_id_prefix) + strlen($product_id_prefix), strpos($each_product, $product_id_prefix_end) - (strpos($each_product, $product_id_prefix) + strlen($product_id_prefix)));
        $products[$j]['id'] = $product_id;

        $product_name_prefix = $product_id . '.html" title="';
        $product_name_prefix_end = '" class="' . $product_id;
        $product_name = substr($each_product, strpos($each_product, $product_name_prefix) + strlen($product_name_prefix), strpos($each_product, $product_name_prefix_end) - (strpos($each_product, $product_name_prefix) + strlen($product_name_prefix)));
        $products[$j]['name'] = $product_name;

        $product_prize_prefix = 'tp_product_price">';
        $product_prize_prefix_end = ' ₫</span>';
        $product_prize = substr($each_product, strpos($each_product, $product_prize_prefix) + strlen($product_prize_prefix), strpos($each_product, $product_prize_prefix_end) - (strpos($each_product, $product_prize_prefix) + strlen($product_prize_prefix)));
        $products[$j]['prize'] = str_replace(",", "" , $product_prize);

        $product_image_prefix = 'data-src=\'';
        $product_image_prefix_end = '\' alt=';
        $product_image = substr($each_product, strpos($each_product, $product_image_prefix) + strlen($product_image_prefix), strpos($each_product, $product_image_prefix_end) - (strpos($each_product, $product_image_prefix) + strlen($product_image_prefix)));
        $products[$j]['image'] = $product_image;

        // remove each product after got info
        $fullPage = substr($fullPage, strpos($fullPage, $prefix_each_product) + strlen($prefix_each_product));
        $j++;
      }
    }
*/






 ?>

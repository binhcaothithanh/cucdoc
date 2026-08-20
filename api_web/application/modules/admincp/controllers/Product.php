<?php

/**
 * @property Product_Model $product_model
 */
class Product extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('product_model', 'sku_model', 'attribute_type_model', 'category_model', 'image_model'));
        $this->load->library(array('form_validation', 'resize_image', 'alias'));
        $this->data['cat_id'] = @$_COOKIE['cat_id_product'];
        $this->data['pre1'] = $this->data['pre2'] = 'product';
        $this->load->library('my_category');
        $this->data['categories'] = $this->my_category->build_list_cat();
        $this->data['attribute_types'] = $this->attribute_type_model->get_by('id < 3');
        include APPPATH . 'config/attribute.php';
        $this->data['attr_update'] = $_attrs;
       // $this->$data['role'] = $this->get_role();
    }

    function index() {
        $this->data['category_html'] = $this->load->view('product/loadCategory', $this->data, true);
        $this->data['pos'] = intval(@$_COOKIE['pos_product']);

        $this->template->write_view('content_block', 'product/index', $this->data);
        $this->template->render();
    }

    private function upload_mutiple($files, $path, $cat_id) {
        $this->load->library(array('upload', 'alias', 'resize_image'));
        $cpt = count($_FILES['images']['name']);
        $images = [];
        @mkdir($path . '/goc', 0777);
        $config = array(
            'upload_path' => $path . '/goc',
            'allowed_types' => 'gif|jpg|png|jpeg',
            'overwrite' => FALSE,
        );
        for ($i = 0; $i < $cpt; $i++) {
            $file_name = $_FILES['images']['name'] = $files['images']['name'][$i];
            $file_name = explode('.', $file_name);
            unset($file_name[count($file_name) - 1]);
            $config['file_name'] = $this->alias->create_alias(implode('.', $file_name));
            $this->upload->initialize($config);
            $_FILES['images']['type'] = $files['images']['type'][$i];
            $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
            $_FILES['images']['error'] = $files['images']['error'][$i];
            $_FILES['images']['size'] = $files['images']['size'][$i];
            $images[$i]['product_id'] = $cat_id;
            if (!$this->upload->do_upload('images')) {
                echo $this->upload->display_errors();
            } else {
                $img = $this->upload->data();
                $images[$i]['name'] = $img['file_name'];
                // $this->resize_image->crop_resize($img['full_path'], $img['full_path'], 650, 650);
                //  $this->resize_image->_watermark($img['full_path'], '650.png');
            }
        }
        return $images;
    }

    private function upload_sku_image($path = '', $list_image = []) {
        $img_default = '';
        $this->load->library(array('alias', 'upload'));
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'gif|jpg|png|jpeg',
            'overwrite' => FALSE,
        );
        foreach ($_FILES as $k => $v) {
            if ($k != 'images' && $v['name']) {
                $file_name = $v['name'];
                $file_name = explode('.', $file_name);
                unset($file_name[count($file_name) - 1]);
                $config['file_name'] = $this->alias->create_alias(implode('.', $file_name));
                $this->upload->initialize($config);
                $k_temp = str_replace('_', ' ', $k);
                if ($this->upload->do_upload($k)) {
                    $img = $this->upload->data();
                    // $this->resize_image->crop_resize($img['full_path'], $img['full_path'], 70, 70);
                    $list_image[$k_temp] = $img['file_name'];
                    if (!$img_default) {
                        $img_default = $img['file_name'];
                    }
                } else {
                    $list_image[$k_temp] = '';
                }
            }
        }
        return array('img_default' => $img_default, 'list_image' => $list_image);
    }

    private function add_product_details($product_id, $path) {
        $upload_sku_image = $this->upload_sku_image($path);
        $img_default = $upload_sku_image['img_default'];
        $list_image = $upload_sku_image['list_image'];
        $count_attr = count($_POST['attr_color']);
        $insert = [];
        $count_total = 0;
        for ($i = 0; $i < $count_attr; $i++) {
            $insert[] = array(
                'color' => $_POST['attr_color'][$i],
                'size' => $_POST['attr_size'][$i],
                'count' => $_POST['count'][$i],
                'product_id' => $product_id,
                'image' => @$list_image[$_POST['attr_color'][$i]] ? $list_image[$_POST['attr_color'][$i]] : $img_default
            );
        }
        if ($insert) {
            $this->sku_model->insert_batch($insert);
        }
    }

    public function add_sku_partner(){
        $listProducts = $this->product_model->get_all();
        $i = 0;
        foreach($listProducts as $eachProduct){
          $insert = '';
              $insert[] = array(
                  'image' => $eachProduct['image']
              );

          $this->sku_model->update_by(array('image' => $eachProduct['image']), 'product_id =' .$eachProduct['id']);
          $i++;
        }
        die('done total ' .$i);
    }

    private function get_product_data($folder, $path) {
        $cat_id = $this->input->post('cat_id');
        $category = $this->category_model->get_by_key($cat_id);
        if ($category['attr_type_keys']) {
            $attr_type_keys = explode(',', $category['attr_type_keys']);
            foreach ($attr_type_keys as $item) {
                $attr = @implode(',', @$_POST[$item]);
                $attr = $attr ? ',' . $attr . ',' : '';
                $this->data['attr_update'][$item] = $attr;
            }
        }
        setcookie("cat_id_product", $cat_id, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        $alias = $this->alias->create_alias($this->input->post('title'));
        $data = array(
            'title' => $this->input->post('title'),
            'alias' => $alias,
            'username' => $this->data['username'],
            'product_status' => $this->input->post('product_status'),
            'can_buy' => $this->input->post('can_buy'),
            'cat_id' => $cat_id,
            'content' => html_entity_decode($this->input->post('content'), ENT_COMPAT, 'UTF-8'),
            'meta_keyword' => $this->input->post('meta_keyword'),
            'folder' => $folder,
            'price' => $this->input->post('price'),
            'cogs' => $this->input->post('cogs'),
            'price_compare' => $this->input->post('price_compare'),
            'seo_title' => $this->input->post('seo_title'),
            'meta_description' => $this->input->post('meta_description')
        );
//        $img_hide = $this->input->post('photo');
//        if ($img_hide != '') {
//            $img_name = $alias . '-' . rand(1, 9999) . '.jpg';
//            $repla = str_replace("data:image/jpeg;base64,", "", $img_hide);
//            $this->resize_image->base64_png($repla, $path . '/' . $img_name);
//            $data['image'] = $img_name;
//        }

        if ($_FILES['photo']['name']) {
            $img_name = $alias . '-' . rand(1, 9999) . '.jpg';
            $this->load->library('upload');
            $config = array(
                'upload_path' => $path,
                'allowed_types' => 'gif|jpg|png|jpeg',
                'overwrite' => FALSE,
                'file_name' => $img_name
            );
            $this->upload->initialize($config);
            if ($this->upload->do_upload('photo')) {
                $img = $this->upload->data();
                //$this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
                $data['image'] = $img_name;
            }
        }

        return array_merge($data, $this->data['attr_update']);
    }

    function add() {
        $this->data['category_html'] = $this->load->view('product/loadCategory', $this->data, true);
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Tên sản phẩm', 'required');
            $this->form_validation->set_rules('price', 'Giá bán', 'required');
            $this->form_validation->set_rules('cat_id', 'Danh mục', 'required');
            if ($this->form_validation->run() == true) {
                $this->data['check_error'] = 1;
                $folder = $this->alias->create_alias($this->input->post('title'));
                if (strlen($folder) > 50)
                    $folder = substr($folder, 0, 50);
                $folder = date('d-m-Y') . '/' . $folder . '-' . time();
                $path = PATH_UPLOAD . 'product/' . $folder;
                $img = '';
                @mkdir(PATH_UPLOAD . 'product/' . date('d-m-Y'), 0777);
                @mkdir($path, 0777);
                $insert = $this->get_product_data($folder, $path);
                $id = $this->product_model->insert($insert);
                $this->add_product_details($id, $path);
                if ($_FILES['images']['name'][0] != '') {
                    $insert_images = $this->upload_mutiple($_FILES, $path, $id);
                    if ($insert_images != '') {
                        $this->image_model->insert_batch($insert_images);
                    }
                }
                $this->product_model->update_count_product($id);
                $this->data['check_error'] = 0;
            } else {
                $this->data['check_error'] = 1;
            }
        }

        $this->template->write_view('content_block', 'product/add', $this->data);
        $this->template->render();
    }

    function update_product_partner(){
      // update list information:
      /*
      category real (id title)
      photos
      attribute
      descripton (content)
      product_status
      brand
      made_in
      */


// UPDATE list null cat_id :
/*
      $listProducts = $this->product_model->get_by('cat_id IS NULL');
      foreach ($listProducts as $product) {
        $product_update = null;
        $product_update = array();
        $linkfull = 'https://bisu.vn/'. trim($product['alias'],'-') . '-p' . $product['partner_id'] . '.html';
        //die($linkfull);
        $fullPage = file_get_contents($linkfull);
        $dom = new DOMDocument();
        @$dom->loadHTML($fullPage);
        $div_tags = $dom->getElementsByTagName('div');
        foreach ($div_tags as $div) {
          if($div->getAttribute('class') == 'chir_breadcrumb '){
              $totalLi = $div->getElementsByTagName('li')->length;
              $li = $div->getElementsByTagName('li')->item($totalLi - 1);  // -1 because start = 0
              $atag = $li->getElementsByTagName('a')->item(0);

              // INFOR: category_partner_id, category_name
              $product_update['category_partner_id'] = trim($atag->getAttribute('class'));
              $product_update['cat_name'] = trim($li->textContent);
              continue;
          }


        $category_real = $this->category_model->get_by('partner_link like "%' . $product_update['category_partner_id'] . '%"' );

        $product_update['cat_id'] = $category_real[0]['id'];
        $this->product_model->update($product_update, $product['id']);

      }
      die('done');
*/

      // get list current products: - Manual get by cat (that root) - for saving time request host bisu
      $listProducts = $this->product_model->get_by('count =0'); // ('cat_id=' . $_GET["cat_id"]);

      $total_record = 0;
      foreach($listProducts as $product){
        $total_record++;


        $product_update = null;
        $product_update = array();
        $linkfull = 'https://bisu.vn/'. trim($product['alias'],'-') . '-p' . $product['partner_id'] . '.html';
        $fullPage = file_get_contents($linkfull);

        $dom = new DOMDocument();
        @$dom->loadHTML($fullPage);

        $div_tags = $dom->getElementsByTagName('div');
        $product_update['count'] = 5;
        // init contentDescription = null:
        $product_update['content'] = '';
        $product_update['image'] = '';
        $product_update['brand'] = '';
        $product_update['made_in'] = '';
        $product_update['category_partner_id'] = '';
        foreach ($div_tags as $div) {


          // for get status prooduct (quantity > 0 or not)
          if(strpos($div->getAttribute('class'), 'detail-info-entry pd_action') !== false){
              $btn = $div->getElementsByTagName('button');
              if($btn->item(0)->nodeValue == 'Mua ngay'){
                $product_update['count'] = 5;
              }else{
                $product_update['count'] = 0;
              }
              continue;
          }else{
            continue; // for do not update anymore !
          }

          // category_partner_id category_partner_name
          if($div->getAttribute('class') == 'chir_breadcrumb '){
              $totalLi = $div->getElementsByTagName('li')->length;
              $li = $div->getElementsByTagName('li')->item($totalLi - 1);  // -1 because start = 0
              $atag = $li->getElementsByTagName('a')->item(0);

              // INFOR: category_partner_id, category_name
              $product_update['category_partner_id'] = trim($atag->getAttribute('class'));
              $product_update['cat_name'] = trim($li->textContent);
              // $this->product_model->update($product_update, $product['id']);
              continue;
          }

          // get MADE IN
          if($div->getAttribute('class') == 'product-detail-box'){
            $span_xuatsu = $div->getElementsByTagName('span');
            foreach($span_xuatsu as $span){
              if($span->getAttribute('style') == 'display: block'){
                $strong = $span->getElementsByTagName('strong')->item(0);
                // INFOR: made in
                $product_update['made_in'] = trim($strong->nodeValue, 'Xuất xứ: ');
              }
            }
            continue;
          }

          // BRAND
          if($div->getAttribute('class') == 'inventStatus'){
            $strong = $div->getElementsByTagName('strong')->item(1);
            //  INFOR: brand
            $product_update['brand'] = $strong->nodeValue;
            continue;
          }

          // IMAGE list
          if($div->getAttribute('id') == 'p-sliderproduct'){
            $listImg = $div->getElementsByTagName('img');
            foreach ($listImg as $img) {

              // INFOR: each image ok
              $product_update['image'] .= $img->getAttribute('src') . ',';

            }
            continue;
          }

          // get content description product
          if(strpos($div->getAttribute('class'), 'swiper-tabs description') !== false) {
             $children  = $div->childNodes;
                $img = $div->getElementsByTagName('img');

                if($img->length > 0){
                  if(strpos($img->item(0)->getAttribute('src'), 'data:image') !== false){
                    foreach($img as $eachImg){
                      $eachImg->hasAttribute('src');
                      $eachImg->removeAttribute('src');
                    }
                  }
                }
             foreach ($children as $child)
             {
                 $product_update['content'] .= $div->ownerDocument->saveHTML($child);
             }
             continue;
          }
        }

        // update product: by $product['id']
        // get real category_id by category_partner_id:
        $category_real = $this->category_model->get_by('partner_link like "%' . $product_update['category_partner_id'] . '%"' );
        $product_update['cat_id'] = $category_real[0]['id'];
        $product_update['image'] = trim($product_update['image'], ',');

        //die('updating '.$product['id'].' ... count  ' . $product_update['count']);
        if($product_update['count'] > 0){
          $this->product_model->update(array('count'=>$product_update['count']), $product['id']);
        }
        //$this->product_model->update($product_update, $product['id']);

      }//end foreach product
      die('finish update ' . $total_record );
    }

    function add_product_partner() {  //runed
      $listCat = $this->category_model->get_by('parent_id = 1');
      foreach($listCat as $eachCat)
      {
         // code get list cat:
         $linkfull = 'https://' . $eachCat['partner_link'];
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
             $products[$j]['partner_id'] = $product_id;
             $products[$j]['partner'] = 'bisu';

             $product_name_prefix = $product_id . '.html" title="';
             $product_name_prefix_end = '" class="' . $product_id;
             $product_name = substr($each_product, strpos($each_product, $product_name_prefix) + strlen($product_name_prefix), strpos($each_product, $product_name_prefix_end) - (strpos($each_product, $product_name_prefix) + strlen($product_name_prefix)));
             $products[$j]['title'] = $product_name;
             $products[$j]['alias'] = $this->alias->create_alias($product_name);
             $products[$j]['seo_title'] = $product_name;


             $product_prize_prefix = 'tp_product_price">';
             $product_prize_prefix_end = ' ₫</span>';
             $product_prize = substr($each_product, strpos($each_product, $product_prize_prefix) + strlen($product_prize_prefix), strpos($each_product, $product_prize_prefix_end) - (strpos($each_product, $product_prize_prefix) + strlen($product_prize_prefix)));
             $products[$j]['price'] = str_replace(",", "" , $product_prize);
             $products[$j]['cogs'] = $products[$j]['price'] - $products[$j]['price']*7/100;


             $product_image_prefix = 'data-src=\'';
             $product_image_prefix_end = '\' alt=';
             $product_image = substr($each_product, strpos($each_product, $product_image_prefix) + strlen($product_image_prefix), strpos($each_product, $product_image_prefix_end) - (strpos($each_product, $product_image_prefix) + strlen($product_image_prefix)));
             $products[$j]['image'] = $product_image;
             $products[$j]['cat_name'] = $eachCat['title'];
             $products[$j]['cat_id'] = $eachCat['id'];

             // remove each product after got info
             $fullPage = substr($fullPage, strpos($fullPage, $prefix_each_product) + strlen($prefix_each_product));
             $j++;

           } // end while product infor
         } // end for every page
         //insert productlist

         foreach($products as $eachPro){
           $this->product_model->insert($eachPro);
         }
      }// end foreach each category
    } // end function


    function upload($id) {
        if ($_FILES['images']['name'][0] != '') {
            $folder = $this->input->post('folder');
            $order = $this->input->post('order') + 1;
            $config['upload_path'] = PATH_PRODUCT . $folder;
            $count = count($_FILES['images']['name']) + $order;
            for ($i = $order; $i < $count; $i++) {
                $order_image[] = $i;
            }
            $insert_images = $this->upload_mutiple($_FILES, $config['upload_path'], $order_image, $id);
            if ($insert_images) {
                $product = $this->product_model->get_by_key($id);
                $content = $product['content'] . '<br/>';
                foreach ($insert_images as $item) {
                    $content.='<img src="/assets/upload/product/' . $folder . '/450/' . $item['name'] . '" class="img-responsive"/><br/><br/>';
                }
                $this->product_model->update(array('content' => $content), $id);
                $this->image_model->insert_batch($insert_images);
            }
        }
        redirect(base_url() . 'product/edit/' . $id . '#image');
    }

    function edit($id = 0) {
        $this->data['check_error'] = -1;
        $this->data['product'] = $this->product_model->get_by_key($id);
        $this->data['images'] = $this->image_model->get_by(array('product_id' => $id));
        $this->data['cat_id'] = $this->data['product']['cat_id'];
        $this->data['category_html'] = $this->load->view('product/loadCategory', $this->data, true);
        if (isset($_POST['submit'])) {

            $this->form_validation->set_rules('title', 'Tên sản phẩm', 'required');
            $this->form_validation->set_rules('price', 'Giá bán', 'required');
            $this->form_validation->set_rules('cat_id', 'Danh mục', 'required');
            if ($this->form_validation->run() == true) {
                $list_image_temp = $this->sku_model->get_list_image($id);
                $img_default = '';
                $list_image = '';
                foreach ($list_image_temp as $item) {
                    if (!$img_default)
                        $img_default = $item['image'];
                    $list_image[$item['color']] = $item['image'];
                }
                $folder = $this->data['product']['folder'];
                $path = PATH_UPLOAD . 'product/' . $folder;
                @mkdir($path, 0777);
                chmod($path, 0777);
                $upload_sku_image = $this->upload_sku_image($path, $list_image);
                $img_default = $img_default ? $img_default : $upload_sku_image['img_default'];
                $list_image = $upload_sku_image['list_image'];

                $insert_sku = '';
                $count_attr = count(@$_POST['attr_color']);
                for ($i = 0; $i < $count_attr; $i++) {
                    $insert_sku[] = array(
                        'color' => $_POST['attr_color'][$i],
                        'size' => $_POST['attr_size'][$i],
                        'count' => $_POST['count'][$i],
                        'product_id' => $id,
                        'image' => @$list_image[$_POST['attr_color'][$i]] ? $list_image[$_POST['attr_color'][$i]] : $img_default
                    );
                }

                // update count SKU
                $count_update_attr = count(@$_POST['ids_update']);
                $update_sku = array();
                for ($i = 0; $i < $count_update_attr; $i++) {
                    $update_sku[] = array(
                        'count' => $_POST['count_update'][$i],
                        'id' => $_POST['ids_update'][$i],
                    );
                }

                foreach ($list_image as $k => $v) {
                    if ($v)
                        $this->sku_model->update_by(array('image' => $v), array('product_id' => $id, 'color' => $k));
                }
                if ($insert_sku)
                    @$this->sku_model->insert_batch($insert_sku);
                if (!empty($count_update_attr))
                    @$this->sku_model->update_batch($update_sku);

                $update = $this->get_product_data($folder, $path);
                $this->product_model->update($update, $id);

                if ($_FILES['images']['name'][0] != '') {
                    $insert_images = $this->upload_mutiple($_FILES, $path, $id);
                    if (!empty($insert_images)) {
                        $this->image_model->insert_batch($insert_images);
                    }
                }
                $this->product_model->update_count_product($id);
                redirect(base_url() . ADMIN_URL . 'product');
                $this->data['check_error'] = 0;
            } else {
                $this->data['check_error'] = 1;
            }
        }

        if ($this->data['product']) {
            $this->data['skus'] = $this->sku_model->get_by('product_id = ' . $id, 'color ASC');
            $this->template->write_view('content_block', 'product/edit', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    function page() {
        $pos = intval(@$_POST['pos']);
        $cond = null;
        $cat_id = @intval($_POST['cat_id']);
        $title = @$_POST['title'];
        if ($cat_id) {
            $parent = @$this->data['categories'][$cat_id];
            if ($parent)
                $cond = 'cat_id in(' . trim(@$parent['child_ids'] . $cat_id) . ')';
            else
                $cond = 'cat_id = ' . $cat_id;
        }
        if ($title) {
            $cond .= $cond ? ' and ' : '';
            $cond.='(id = ' . intval($title) . ' or title like "%' . $title . '%")';
        }

        $order = $_POST['order'] ? $_POST['order'] : 'id DESC';
        $data['results'] = $this->product_model->get_for_page($this->limit, $pos, $cond, $order);
        $total = $this->product_model->get_total_rows($cond);
        setcookie("pos_product", $pos, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        setcookie("cat_id_product", $cat_id, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        $data['links'] = $this->get_page($pos, $total, $this->limit);

		$data['role'] = $this->get_role();
        $this->load->view('product/list', $data);
        return false;
    }

    function del_attr() {
        $sku_id = intval($_POST['id']);
        $this->sku_model->delete($sku_id);
    }

    function del_product_image() {
        $id = intval($_POST['id']);
        $this->image_model->delete($id);
    }

    function update_hot() {
        if (isset($_POST['data'])) {
            $this->product_model->update_batch($_POST['data']);
        }
    }

    function del() {
        $id = intval($_POST['id']);
        $product = $this->product_model->get_by_key($id);
        if (!empty($product)) {
            if ($product['folder']) {
                $this->load->helper("file");
                $dir = PATH_UPLOAD . 'product/' . $product['folder'];
                delete_files($dir . '/goc', true);
                rmdir($dir . '/goc');

                delete_files($dir, true);
                rmdir($dir);
            }
            $this->product_model->delete($id);
            $this->sku_model->delete_where('product_id = ' . $id);
        }
    }
    function del_dupplicate() {
        $product_duplicate = $this->product_model->query_row("select * FROM `product` where id not in( SELECT max(id) FROM `product` group by partner_id)");
        foreach($product_duplicate as $eachDel){
            $this->product_model->delete($eachDel['id']);
        }
    }

}

<?php

class Script extends CI_Controller {

    public function __construct() {
        parent::__construct();
        die('scipt in '
        exit;
    }


    function script_article($pro_id = 0) {
        $this->load->model(array('product_model', 'image_model','sku_model'));
        $product = $this->product_model->get_row_by('id > ' . $pro_id);
        if (!empty($product)) {
            echo '<pre>';
            print_r($product);
            include APPPATH . 'libraries/simple_html_dom.php';
            echo $product['url'] . '<br/>';
            $html = file_get_html($product['url']);
            $rows = $html->find('.cm-preview-wrapper a');
            $folder = date('d-m-Y') . '/' . $product['alias'] ;
            $path = PATH_UPLOAD . 'product/' . $folder . '/goc/';
            @mkdir($path, 0777, true);
            $this->load->library(array('transload', 'resize_image'));
            $insert_image = array();
            foreach ($rows as $k => $item) {
                echo $img = $item->href;
                $image_name = 'image' . $k . '.jpg';
                if ($this->transload->transload_img($img, $path . $image_name)) {
                    if ($k == 0) {
                        $this->resize_image->crop_resize($path . $image_name, $path . '/../' . 'default.jpg', 300, 400);
                        $this->resize_image->crop_resize($path . $image_name, $path . '/../' . 'sku.jpg', 60, 80);
                    }
                    $this->resize_image->thumb_width($path . $image_name, $path . $image_name, 650);
                }
                $insert_image[] = array(
                    'product_id' => $product['id'],
                    'name' => $image_name
                );
            }
            @$this->image_model->insert_batch($insert_image);
            $this->product_model->update(array('folder' => $folder, 'image' => 'default.jpg'), $product['id']);
            echo '<META http-equiv="refresh" content="0;URL=/script/script_article/' . $product['id'] . '">';
        }
    }

    function index($index = 0, $page = 1) {
        $maps_category = $this->maps_category();
        $cat = $maps_category[$index];
        if (!empty($cat)) {
            $this->load->model(array('product_model', 'sku_model'));
            include APPPATH . 'libraries/simple_html_dom.php';
            echo $url = $cat['url'] . 'page-' . $page;
            $html = file_get_html($url);
            $row = $html->find('.ty-column3');
            $this->load->library('alias');
            $skus;
            foreach ($row as $item) {
                $price_compare = @$item->find('.ty-nowrap .ty-strike', 0)->plaintext;
                $title = @$item->find('.ty-grid-list__item-name a', 0)->plaintext;
                if ($title) {
                    $insert = array(
                        'url' => $item->find('a', 0)->href,
                        'title' => $title,
                        'alias' => $this->alias->create_alias($title),
                        'meta_keyword' => $title,
                        'seo_title' => $title,
                        'meta_description' => $title,
                        'price' => intval(str_replace(',', '', $item->find('.ty-price-num', 0)->plaintext)) * 1000,
                        'price_compare' => intval(str_replace(',', '', $price_compare)) * 1000,
                        'count' => 10,
                        'cat_id' => $cat['cat_id']
                    );

                    $product_id = $this->product_model->insert($insert);
                    $skus[] = array(
                        'color' => 'VIP',
                        'product_id' => $product_id,
                        'count' => 10
                    );
                }
            }
            echo '<pre>';
                        print_r($skus);

            @$this->sku_model->insert_batch($skus);
            $page++;
            $limit = isset($cat['page']) ? $cat['page'] : 1;
            if ($page > $limit) {
                $index++;
                $page = 1;
            }
            echo '<META http-equiv="refresh" content="0;URL=/script/index/' . $index . '/' . $page . '">';
        }
    }

    function maps_category() {
        return array(
            array(
                'cat_id' => 2,
                'url' => 'http://shopdaophuot.com/dao-pht/ao/ao-ph-thong/',
            ),
            array(
                'cat_id' => 3,
                'url' => 'http://shopdaophuot.com/dao-pht/ao/ao-cao-cp/',
            ),
            array(
                'cat_id' => 12,
                'url' => 'http://shopdaophuot.com/dao-pht/dng-c-t-v/baton-ba-trc/',
            ),
            array(
                'cat_id' => 13,
                'url' => 'http://shopdaophuot.com/dao-pht/dng-c-t-v/binh-xt-hi-cay/',
            ),
            array(
                'cat_id' => 14,
                'url' => 'http://shopdaophuot.com/dao-pht/dng-c-t-v/dng-c-chich-in/',
            ),
            array(
                'cat_id' => 15,
                'url' => 'http://shopdaophuot.com/dao-pht/dng-c-t-v/tay-gu/',
            ),
            array(
                'cat_id' => 5,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-nh/dao-bm/',
            ),
            array(
                'cat_id' => 6,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-nh/dao-gp/',
                'page' => 2
            ),
            array(
                'cat_id' => 7,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-nh/dao-ch-t/',
            ),
            array(
                'cat_id' => 8,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-nh/kubaton/',
            ),
            array(
                'cat_id' => 9,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-nh/dao-gm/',
                'page' => 2
            ),
            array(
                'cat_id' => 10,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-ln/git-l-qum/',
            ),
            array(
                'cat_id' => 11,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-ln/le-cac-mu-le-quan-i/',
            ),
            array(
                'cat_id' => 23,
                'url' => 'http://shopdaophuot.com/dao-pht/dao-c-bit/le-xon-kim-ng/',
            ),
            array(
                'cat_id' => 17,
                'url' => 'http://shopdaophuot.com/dao-pht/karambit/karambit-tp/',
            ),
            array(
                'cat_id' => 18,
                'url' => 'http://shopdaophuot.com/dao-pht/karambit/karambit-gp/',
            ),
            array(
                'cat_id' => 19,
                'url' => 'http://shopdaophuot.com/dao-pht/karambit/karambit-full-tang/',
            ),
            array(
                'cat_id' => 20,
                'url' => 'http://shopdaophuot.com/dao-pht/phi-tieu/shuriken/',
            ),
            array(
                'cat_id' => 21,
                'url' => 'http://shopdaophuot.com/dao-pht/phi-tieu/kunai/',
            ),
            array(
                'cat_id' => 22,
                'url' => 'http://shopdaophuot.com/dao-pht/phi-tieu/phi-tieu-c-bit/',
            ),
            array(
                'cat_id' => 25,
                'url' => 'http://shopdaophuot.com/kim/kim-nht/',
            ),
            array(
                'cat_id' => 31,
                'url' => 'http://shopdaophuot.com/balisong-vietnam/dao-tp/',
            ),
            array(
                'cat_id' => 32,
                'url' => 'http://shopdaophuot.com/balisong-vietnam/balisong-can-ghep/',
                'page' => 2
            ),
            array(
                'cat_id' => 33,
                'url' => 'http://shopdaophuot.com/balisong-vietnam/balisong-can-uc/',
            ),
            array(
                'cat_id' => 34,
                'url' => 'http://shopdaophuot.com/balisong-vietnam/balisong-c-bit/',
            ),
        );
    }

}

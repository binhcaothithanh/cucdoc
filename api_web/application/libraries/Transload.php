<?php

class Transload {

    function __construct() {
        $this->CI = &get_instance();
    }

    function transload_img($linktranload, $pathFileName) {
        if (strpos($linktranload, "?")) {
            $temp = explode("?", $linktranload);
            $linktranload = $temp[0];
        }

        $data = explode('.', $linktranload);
        $file_type = strtolower($data[count($data) - 1]);
        if ($file_type == 'jpg' || $file_type == 'png' || $file_type = 'jpeg') {
            $handle = @fopen($linktranload, "rb");
            $contents = @stream_get_contents($handle);
            @fclose($handle);
            $f2 = @fopen($pathFileName, "w");
            @fwrite($f2, $contents);
            @fclose($f2);
            if (file_exists($pathFileName) && filesize($pathFileName) && getimagesize($pathFileName)) {
                return filesize($pathFileName);
            } else {
                @unlink($pathFileName);
                return false;
            }
        }
        return false;
    }

    function split_content($tag_start, $tag_end, $str) {
        $temp = '';
        $temp1 = '';
        $result = '';
        $temp = explode($tag_start, $str);
        if (count($temp) > 2) {
            for ($i = 1; $i < count($temp); $i++) {
                $temp1 = explode($tag_end, $temp[$i]);
                $result[] = $temp1[0];
            }
        } else {
            $temp1 = @explode($tag_end, $temp[1]);
            $result[] = $temp1[0];
        }


        return $result;
    }

    function isValidURL($url) {
        if (strpos($url, URL_FONTEND) === false) {
            return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
        }
        return false;
    }

    function crop_resize($img, $new_image, $thumb_w, $thumb_h, $position = 'center') {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;
        $percent_w = $cf[0] / $thumb_w;
        $percent_h = $cf[1] / $thumb_h;
        $percent = $percent_w > $percent_h ? $percent_h : $percent_w;
        $config['width'] = $thumb_w * $percent;
        $config['height'] = $thumb_h * $percent;
        $config['x_axis'] = ($cf[0] - $config['width']) / 2;
        $config['y_axis'] = ($cf[1] - $config['height']) / 2;
        $this->CI->load->library('image_lib');
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->crop();
        $config['width'] = $thumb_w;
        $config['height'] = $thumb_h;
        $config['new_image'] = $new_image;
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
    }

    function get_image($content, $folder, $dir, $no_image, $alias) {
        $dir = $dir . $folder;
        $list_image = $this->split_content('<img', '>', $content);
        $get_no_image = 0;
        for ($i = 0; $i < count($list_image); $i++) {
            $temp = '';
            $temp = $this->split_content('src="', '"', $list_image[$i]);
            if (!$temp[0]) {
                $temp = $this->split_content("src='", "'", $list_image[$i]);
            }
            $arr_list_image[] = $temp[0];
        }
        $img_url = '/assets/upload/page/' . $folder;
        for ($i = 0; $i < count($arr_list_image); $i++) {
            if ($this->isValidURL($arr_list_image[$i])) {
                $temp = explode("?", $arr_list_image[$i]);
                $filename_url_grab[$i] = basename($arr_list_image[$i]);
                if (strpos($filename_url_grab[$i], "?")) {
                    $temp = explode("?", $filename_url_grab[$i]);
                    $filename_url_grab[$i] = $temp[0];
                }
                $filename_url_ext[$i] = substr($filename_url_grab[$i], -3);
                if (strtolower($filename_url_ext[$i]) == 'jpg' || strtolower($filename_url_ext[$i]) == 'png' || strtolower($filename_url_ext[$i]) == 'peg') {
                    $filename[$i] = random_string("alnum") . '.jpg';
                    $ok = $this->transload_img($arr_list_image[$i], $dir . $filename[$i]);
                    if ($ok) {
                        if ($get_no_image == 0 && $no_image) {
                            $abc = getimagesize($dir . $filename[$i]);
                            if ($abc[0] >= 230) {
                                $this->crop_resize($dir . $filename[$i], $dir . $alias . '.jpg', 230, 150);
                                $get_no_image = 1;
                            }
                        }
                        $this->thumb_width($dir . $filename[$i], $dir . $filename[$i], 650);

                        $content = str_replace($list_image[$i], ' src="' . $img_url . $filename[$i] . '"', $content);
                        //$content = str_replace($arr_list_image[$i], $img_url . $filename[$i], $content);
                    }
                }
            }
        }
        $content = preg_replace('/<a href="(.+)">/', '', $content);
        return array('content' => $content, 'get_no_image' => $get_no_image);
    }

    function get_image_for_page($content) {
        $list_image = $this->split_content('<img', '>', $content);

        for ($i = 0; $i < count($list_image); $i++) {
            $temp = '';
            $temp = $this->split_content('src="', '"', $list_image[$i]);
            if (!$temp[0]) {
                $temp = $this->split_content("src='", "'", $list_image[$i]);
            }
            $arr_list_image[] = $temp[0];
        }
        $img_url = '/assets/upload/page/';
        $dir = PATH_PAGE;
        for ($i = 0; $i < count($arr_list_image); $i++) {
            $img_url_blogger = '';
            if ($this->isValidURL($arr_list_image[$i])) {
                $temp = explode("?", $arr_list_image[$i]);
                $filename_url_grab[$i] = basename($arr_list_image[$i]);
                if (strpos($filename_url_grab[$i], "?")) {
                    $temp = explode("?", $filename_url_grab[$i]);
                    $filename_url_grab[$i] = $temp[0];
                }
                $filename_url_ext[$i] = substr($filename_url_grab[$i], -3);
                if (strtolower($filename_url_ext[$i]) == 'jpg' || strtolower($filename_url_ext[$i]) == 'png' || strtolower($filename_url_ext[$i]) == 'peg') {
                    $filename[$i] = random_string("alnum", 5) . '.jpg';
                    $ok = $this->transload_img($arr_list_image[$i], $dir . $filename[$i]);
                    if ($ok) {
                        $this->crop($dir . $filename[$i]);
                        $this->thumb_width($dir . $filename[$i], $dir . $filename[$i], 650);
                        $content = str_replace($list_image[$i], ' src="' . $img_url . $filename[$i] . '"', $content);
                        //$content = str_replace($arr_list_image[$i], $img_url . $filename[$i], $content);
                    }
                }
            }
        }

        //  $content = preg_replace('#(.+?)width="(.+?)"(.+?)height="(.+?)"(.*)#is', '\\1\\5', $content);
        // $content = preg_replace('/<a href="(.+)">/', '', $content);      
        return $content;
    }

    function thumb_width($img, $new_image, $width, $wmark = TRUE) {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;
        if ($cf[0] < $width) {
            $config['width'] = $cf[0];
            $config['height'] = $cf[1];
        } else {
            $percent = $cf[0] / $width;
            $config['width'] = $width;
            $config['height'] = $cf[1] / $percent;
        }
        $config['new_image'] = $new_image;
        $this->CI->load->library('image_lib');
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
        if ($wmark == TRUE)
            $this->_watermark($new_image, $width . '.png');
    }

    function crop($img) {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;
        $config['width'] = $cf[0];
        $config['height'] = $cf[1] - 20;
        $config['x_axis'] = 0;
        $config['y_axis'] = 0;
        $this->CI->load->library('image_lib');
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->crop();
    }

    function _watermark($new_image, $watermark) {
        $this->CI->load->library('image_lib');
        $config['create_thumb'] = FALSE;
        $config['source_image'] = $new_image;
        $config['wm_overlay_path'] = APPPATH . '../assets/upload/' . $watermark;
        $config['wm_type'] = 'overlay';
        $config['dynamic_output'] = TRUE;
        $config['wm_vrt_alignment'] = 'B';
        $config['wm_hor_alignment'] = 'R';
        $config['dynamic_output'] = false;
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->watermark();
        $this->CI->image_lib->display_errors();
    }

}

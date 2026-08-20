<?php

class Resize_Image {

    function __construct() {
        $this->CI = $this->CI = & get_instance();
    }

    function base64_png($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb");
        fwrite($ifp, base64_decode($base64_string));
        fclose($ifp);
    }

    function _thumb($img, $new_image, $width, $height, $fit = false) {
        $this->CI->load->library('image_lib');
        $config['source_image'] = $img;
        $config['new_image'] = $new_image;
        $config['image_library'] = 'gd2';
        $config['master_dim'] = 'width';
        $config['width'] = $width;
        $config['height'] = $height;
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        if ($fit) {
            $this->CI->image_lib->fit();
        } else {
            $this->CI->image_lib->resize();
        }
    }

    function thumb_width($img, $new_image, $width) {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;
        if ($cf['0'] > $width) {
            $percent = $cf[0] / $width;
            $config['width'] = $width;
            $config['height'] = $cf[1] / $percent;
        } else {
            $config['width'] = $cf[0];
            $config['height'] = $cf[1];
        }

        $config['new_image'] = $new_image;
        $this->CI->load->library('image_lib');
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
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

    function crop($img) {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = false;
        $config['width'] = $cf[0];
        $config['height'] = $cf[1] - 100;
        $config['x_axis'] = 0;
        $config['y_axis'] = 0;
        $this->CI->load->library('image_lib');
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->crop();
    }

    function crop_resize($img, $new_image, $thumb_w, $thumb_h, $position = 'center') {
        $cf = getimagesize($img);
        $config['source_image'] = $img;
        $config['new_image'] = $new_image;
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
        $config['source_image'] = $new_image;
        $config['new_image'] = $new_image;
        $this->CI->image_lib->initialize($config);
        $this->CI->image_lib->resize();
    }

}

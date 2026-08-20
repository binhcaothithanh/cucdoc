<?php

class Api {

    function call_api($url = 'addCategory', $method = "get", $data = '') {

        $server_ip = 'http://54.169.67.166:8080/' . $url;
        $data = @$this->doRequest($server_ip, $data, $method);
        return json_decode($data, true);
    }

    private function doRequest($url, $vars, $method = 'post') {        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);      
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'put') {            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        } elseif ($method == 'delete') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        } elseif ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        if ($method != 'get') {
            $data_json = json_encode($vars);
            //echo $data_json;exit;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        }


        $data = curl_exec($ch);
        curl_close($ch);
        if ($data) {
            return $data;
        } else {
            return @curl_error($ch);
        }
    }

}

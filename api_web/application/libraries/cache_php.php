<?php

class Cache_php {

    //-- Tên biến mặc định khi tạo dữ liệu PSON
    //
	var $strDataName = 'strPsonData';
    //-- Ký hiệu để xuống hàng
    //-- Thiết lập bằng rỗng nếu muốn tiết kiệm bộ nhớ, nhưng sẽ khó đọc...
    //
	var $chrBreak = "\n";
    //-- Ký hiệu để đẩy tab
    //-- Thiết lập bằng rỗng nếu muốn tiết kiệm bộ nhớ, nhưng sẽ khó đọc...
    //
	var $chrTab = "\t";
    var $story = false;

    //-- Construction, truyền biến để thay đổi tên biến mặc định của dữ liệu PSON nếu thích
    //-- Gọi khởi tạo theo dạng: $P = new PSON('my_pson_data');
    //
	function PSON($strVar = '') {
        if ($strVar)
            $this->strDataName = $strVar;
    }

    function set_story() {

        $this->story = true;
    }

    function encode_pgc($strText) {
        if (get_magic_quotes_runtime() || get_magic_quotes_gpc()) {
            $strText = stripcslashes($strText);
        }
        //return $strText;        
        if ($this->story) {
            return str_replace(array("'", '\\'), array('&#39;', '&#92;'), $strText);
        }
        return str_replace(array('"', "'", '\\'), array('&quot;', '&#39;', '&#92;'), $strText);
    }

    //-- Chuyển biến dạng array thành một chuỗi có khai báo giá trị đúng như biến mảng
    //-- Ví dụ: $a = array(1, 2, 3); => $data = "array(1, 2, 3);";
    //
	function _pson_arr2str($arrVar, $intLevel = 0) {
        if (!is_array($arrVar))
            return false;

        $strTab = str_repeat($this->chrTab, $intLevel);

        $strHtml = 'array' . $this->chrBreak . $strTab . '(' . $this->chrBreak;

        foreach ($arrVar as $strKey => $mixVal) {


            if (is_array($mixVal)) {
                $strHtml .= $strTab . $this->chrTab . (is_int($strKey) ? '\'' . $strKey . '\' => ' : '\'' . $this->encode_pgc($strKey) . '\' => ') . $this->_pson_arr2str($mixVal, ++$intLevel);
                --$intLevel;
            } else {
                if (!is_int($strKey)) {
                    $strHtml .= $strTab . $this->chrTab . '\'' . $this->encode_pgc($strKey) . '\' => \'' . $this->encode_pgc($mixVal) . '\',' . $this->chrBreak;
                } else {

                    $strHtml .= $strTab . $this->chrTab . '\'' . $strKey . '\' => \'' . $this->encode_pgc($mixVal) . '\',' . $this->chrBreak;
                }
            }
        }

        $strHtml .= $strTab . ')';

        if ($intLevel) {
            $strHtml .= ',' . $this->chrBreak;
        } else {
            $strHtml = '$' . $this->strDataName . ' = ' . $strHtml . ';';
        }

        return $strHtml;
    }

    function arr2str($arrVar) {
        return $this->_pson_arr2str($arrVar);
    }

    //-- Đọc file dữ liệu và trả về biến mảng
    //
	function pson_load($strFileName) {
        if (file_exists($strFileName))
            include $strFileName;
        else
            return false;

        $strValName = $this->strDataName;
        $arrData = $$strValName;

        return $arrData;
    }

    function pson_save($arrVal, $strFileName) {
        if ($f = @fopen($strFileName, 'wb')) {
            if (@fwrite($f, '<?php' . "\n" . $this->_pson_arr2str($arrVal) . "\n" . '$time=' . time() . ';?>')) {
                if (@fclose($f)) {
                    return true;
                }
            }
        }

        return false;
    }

    function get_data($file_name) {
        if (!IS_CACHE) {
            return false;
        }
        $strPsonData = '';
        $time = 0;
        @include $file_name;
        if ($time + TIME_CACHE_DB < time()) {
            return false;
        }

        return $strPsonData;
    }

    function get_keyword($path) {
        $keyword = '';
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = strtolower(urldecode($_SERVER['HTTP_REFERER']));
            if (strpos($referer, 'google.com') !== false) {
                if (strpos($referer, '#q=')) {
                    $referer = explode('#q=', $referer);
                    $keyword = $referer[1];
                } else {
                    $referer = parse_url($referer);
                    parse_str($referer['query'], $result);
                    $keyword = $result['q'];
                }
                if (strpos($keyword, 'site:')) {
                    $keyword = explode('site:', $keyword);
                    $keyword = trim($keyword[0]);
                }
            }
        }
        @$str = file_get_contents($path);
        if ($keyword) {
            if (strpos($str, $keyword . chr(0)) === false) {
                $str.=$keyword . chr(0);
                file_put_contents($path, $str);
            }
        }
        if ($str) {
            $str = explode(chr(0), $str);
            array_pop($str);
            return $str;
        }
        return '';
    }

}

?>
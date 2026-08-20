<?php

class MY_Upload extends CI_Upload {

    function _prep_filename($filename) {
        if (strpos($filename, '.') === false) {
            return $filename;
        }

        $parts = explode('.', $filename);
        $ext = array_pop($parts);
        $filename = array_shift($parts);

        foreach ($parts as $part) {
            if ($this->mimes_types(strtolower($part)) === false) {
                $filename .= '.' . $part . '_';
            } else {
                $filename .= '.' . $part;
            }
        }

        $filename .= '.' . $ext;

        return strtolower($filename);
    }

    function get_extension($filename) {
        $x = explode('.', $filename);
        return strtolower('.' . end($x));
    }

}

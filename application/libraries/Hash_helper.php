<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Hash_helper
{
    function arr2md5($arrinput)
    {
        $hasil = '';
        foreach ($arrinput as $val) {
            if ($hasil == '') {
                $hasil = md5($val);
            } else {
                $code = md5($val);
                for ($hit = 0; $hit < min(strlen($code), strlen($hasil)); $hit++) {
                    $hasil[$hit] = chr(ord($hasil[$hit]) ^ ord($code[$hit]));
                }
            }
        }
        return md5($hasil);
    }
}
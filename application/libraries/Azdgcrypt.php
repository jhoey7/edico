<?php

class azdgcrypt {

    var $k = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWQYZ';

    function setKey($m) {
        $this->k = $m;
    }

    function ed($t) {
        $r = md5($this->k);
        $c = 0;
        $v = "";
        for ($i = 0; $i < strlen($t); $i++) {
            if ($c == strlen($r))
                $c = 0;
            $v .= substr($t, $i, 1) ^ substr($r, $c, 1);
            $c++;
        }
        return $v;
    }

    function crypt($t="") {
        if($t) {
            srand((double) microtime() * 1000000);
            $r = md5(rand(0, 32000));
            $c = 0;
            $v = "";
            $ln = strlen($t);
            for ($i = 0; $i < $ln; $i++) {
                if ($c == strlen($r))
                    $c = 0;
                $v .= substr($r, $c, 1) . (substr($t, $i, 1) ^ substr($r, $c, 1));
                $c++;
            }
            $rtn = str_replace('/', '-', base64_encode($this->ed($v)));
            return $rtn;
        }
    }

    function decrypt($t="") {
        if($t) {
            $t = str_replace('-', '/', $t);
            $t = $this->ed(base64_decode($t));
            $v = "";
            for ($i = 0; $i < strlen($t); $i++) {
                $md5 = substr($t, $i, 1);
                $i++;
                $v .= (substr($t, $i, 1) ^ $md5);
            }
            return $v;
        }
    }

}

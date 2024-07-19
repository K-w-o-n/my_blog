<?php

namespace Routes;

class HTTP {

    static $address = "http://localhost/my_blog";

    static function redirect($path, $q="") {

        $url = static::$address .$path;

        if($q) $url .="?$q";

        header("location: $url");
        exit();
    }
}
<?php

class ParameterUtil {

    const SECRET_KEY   = "4fR";

    public static function encode($code) {

    	return base64_encode(self::SECRET_KEY.$code);
    }

    public static function decode($code){

    	return str_replace(self::SECRET_KEY , "", base64_decode($code));
    }
}


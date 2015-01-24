<?php

namespace Security\Helpers;

use Log;
use Request;

class LogHelper {

    private static $request_id;
    private static $context_array;

    public static function beginRequest() {
        self::$request_id = RandomHelper::digitsAndLowercase(32);
        self::$context_array = array('rqid' => self::$request_id);

        self::info('BEGIN ' . Request::getClientIp() . ' ' . Request::method() . ' ' . Request::path() . ' ' .
            json_encode(Request::except(array('password'))));
    }

    public static function endRequest() {
        self::info('END ');
    }

    public static function getRequestId() {
        return self::$request_id;
    }

    public static function debug($message) {
        Log::debug($message, self::$context_array);
    }

    public static function info($message) {
        Log::info($message, self::$context_array);
    }

    public static function notice($message) {
        Log::notice($message, self::$context_array);
    }

    public static function warning($message) {
        Log::warning($message, self::$context_array);
    }

    public static function error($message) {
        Log::error($message, self::$context_array);
    }

    public static function critical($message) {
        Log::critical($message, self::$context_array);
    }

    public static function alert($message) {
        Log::alert($message, self::$context_array);
    }

    public static function emergency($message) {
        Log::emergency($message, self::$context_array);
    }

}

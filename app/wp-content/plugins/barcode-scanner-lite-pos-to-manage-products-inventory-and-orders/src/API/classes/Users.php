<?php

namespace UkrSolution\BarcodeScanner\API\classes;

class Users
{
    public static function getUserId($request)
    {
        global $wpdb;

        $userId = get_current_user_id();
        $token = $request->get_param("token");

        if (!$userId && $token) {

            try {
                if (preg_match("/^([0-9]+)/", @base64_decode($token), $m)) {
                    if ($m && count($m) > 0 && is_numeric($m[0])) {
                        $userId = $m[0];
                    }
                } else {
                    $meta = $wpdb->get_row("SELECT * FROM {$wpdb->usermeta} WHERE meta_key = 'barcode_scanner_app_otp' AND meta_value = '{$token}';");
                    $userId = $meta ? $meta->user_id : $userId;
                }
            } catch (\Throwable $th) {
            }
        }

        return $userId;
    }
}

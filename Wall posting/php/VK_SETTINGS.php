<?php

class VKSETTINGS
{
    // STANDALONE VK APPLICATION ONLY!!!
    // check parameters of your application at https://vk.com/apps?act=manage
    private static $setup_settings =
        ['client_id' => "6209923", // VK application id
            'app_key' => "DHv0hZerNobNVOtXnWm6", // VK application secret key
            'redirect_uri' => "http://nesterus.h1n.ru/", // must be checked with trusted redirect URL specified in VK application settings panel
            'v' => 5.68];

    public static function get_client_id () {
            return (self::$setup_settings['client_id']);
    }

    public static function get_app_key () {
        return (self::$setup_settings['app_key']);
    }

    public static function get_redirect_uri() {
        return (self::$setup_settings['redirect_uri']);
    }
}

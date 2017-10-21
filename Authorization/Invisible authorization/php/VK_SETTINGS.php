<?php

class VKSETTINGS
{
    // WEBSITE ONLY!!!
    // check parameters of your application at https://vk.com/apps?act=manage
    private static $setup_settings =
        ['client_id' => "6217072", // VK application id
            'app_key' => "Yw4uHVgjqisyTGzW18bM", // VK application secret key
        ];

    public static function get_client_id()
    {
        return (self::$setup_settings['client_id']);
    }

    public static function get_app_key()
    {
        return (self::$setup_settings['app_key']);
    }
}

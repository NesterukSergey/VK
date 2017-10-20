<?php

class VK
{
    private $settings;
    private $scope;
    private $code;
    private $token;
    private $user_id;
    private $request_options = [
        'response_type' => 'code',
        'display' => 'page'
    ];

    // requires vk_settings.php
    function __construct($settings)
    {
        $this->settings = $settings;

        if ((isset($_SESSION['vk_token']))) {
            $this->token = $_SESSION['vk_token'];
        }

        if ((isset($_SESSION['vk_user_id']))) {
            $this->user_id = $_SESSION['vk_user_id'];
        }
    }

    // @param string $scope
    public function authorize($scope)
    {
        $this->scope = $scope;
        $this->create_login_link();
    }

    public function set_code($code)
    {
        $this->code = $code;
        $this->set_token();
    }

    private function set_token()
    {
        $request_params = [
            'client_id' => $this->settings['client_id'],
            'client_secret' => $this->settings['app_key'],
            'redirect_uri' => $this->settings['redirect_uri'],
            'code' => $this->code
        ];

        $query = "https://oauth.vk.com/access_token?" . http_build_query($request_params);

        @$result = json_decode(file_get_contents($query), true);

        $this->token = $result['access_token'];
        $_SESSION['vk_token'] = $result['access_token'];

        $this->user_id = $result['user_id'];
        $_SESSION['vk_user_id'] = $result['user_id'];

        var_dump($result);
    }

    private function create_login_link()
    {
        $request_params = [
            'client_id' => $this->settings['client_id'],
            'redirect_uri' => $this->settings['redirect_uri'],
            //'redirect_uri' => "https://oauth.vk.com/blank.html",
            'response_type' => $this->request_options['response_type'],
            'display' => $this->request_options['display'],
            'scope' => $this->scope,
            'v' => $this->settings['v']
        ];
        $request_params['state'] = hash('md5', implode("", $request_params));

        $query = "https://oauth.vk.com/authorize?" . http_build_query($request_params);

        echo("<a id='vkbutton' href='" . $query . "'>Войти через Вконтакте</a>");
    }
}
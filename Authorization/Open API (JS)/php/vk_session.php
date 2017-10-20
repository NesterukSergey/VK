<?php
require_once "VK_SETTINGS.php";

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'check_session':
            check_session($_POST['data']);
            break;
        case 'get_client_id':
            VKSETTINGS::get_client_id();
            break;
        default:
            echo "No such method!";
    }
}

function check_session($session_data) {
    //TODO: match session data coincides with database
    $user_id = $session_data['user']['id'];
    $user_link = $session_data['user']['href'];
    $user_name = $session_data['user']['first_name'];
    $user_last_name = $session_data['user']['last_name'];

    $member = authOpenAPIMember();
    if($member == FALSE) {
        echo "Пользователь не авторизован!";
        return false;
    }

    //TODO: return UI changes
}

// authOpenAPIMember() checks authorization correctness
function authOpenAPIMember() {
    $session = array();
    $member = FALSE;
    $valid_keys = array('expire', 'mid', 'secret', 'sid', 'sig');
    $app_cookie = $_COOKIE['vk_app_'.VKSETTINGS::get_client_id()];
    if ($app_cookie) {
        $session_data = explode ('&', $app_cookie, 10);
        foreach ($session_data as $pair) {
            list($key, $value) = explode('=', $pair, 2);
            if (empty($key) || empty($value) || !in_array($key, $valid_keys)) {
                continue;
            }
            $session[$key] = $value;
        }
        foreach ($valid_keys as $key) {
            if (!isset($session[$key])) return $member;
        }
        ksort($session);

        $sign = '';
        foreach ($session as $key => $value) {
            if ($key != 'sig') {
                $sign .= ($key.'='.$value);
            }
        }
        $sign .= VKSETTINGS::get_app_key();
        $sign = md5($sign);
        if ($session['sig'] == $sign && $session['expire'] > time()) {
            $member = array(
                'id' => intval($session['mid']),
                'secret' => $session['secret'],
                'sid' => $session['sid']
            );
        }
    }
    return $member;
}
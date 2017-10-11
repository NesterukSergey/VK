<?php
require_once "VK_SETTINGS.php";

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'check_session':
            check_session($_POST['data']['uid'], $_POST['data']['hash']);
            break;
        case 'get_client_id':
            VKSETTINGS::get_client_id();
            break;
        default:
            echo "No such method!";
    }
}

function check_session($uid, $hash) {
    $standard = md5(VKSETTINGS::get_client_id() . $uid . VKSETTINGS::get_app_key());

    echo (($standard === $hash) ? 'connected' : 'not authorized');
}
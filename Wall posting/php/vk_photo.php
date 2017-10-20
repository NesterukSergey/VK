<?php
function upload_photo($data)
{
    $url = $data['upload_server']['response']['upload_url'];
    $image = $data['image'];

    $post_data = array("file1" => '@' . $image);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $upload_result = json_decode(curl_exec($ch), true);

    $safe_request_params = [
        'server' => $upload_result['server'],
        'photo' => stripslashes($upload_result['photo']),
        'hash' => $upload_result['hash'],
    ];

    return json_encode($safe_request_params);
}
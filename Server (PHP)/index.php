<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
require_once('php/vk_settings.php');
require_once('php/vk.php');

if (!(isset($_SESSION['vk_token']))) {
    if (!(isset($_GET['code']))) {
        $vk = new VK ($settings);
        $vk->authorize("photos,offline,wall");
    } else {
        $vk = new VK ($settings);
        $vk->set_code($_GET['code']);
    }
}

?>
</body>
</html>
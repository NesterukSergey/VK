<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>VK wall test</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="https://vk.com/js/api/openapi.js?149" type="text/javascript"></script>
    <script src="js/vk.js"></script>
    <script src="js/vk_wall.js"></script>
</head>
<body>
<section id="vk_module">
    <?php include_once 'php/VK_SETTINGS.php' ?>

    <script type="text/javascript">
        VK.init({
            apiId: <?php echo VKSETTINGS::get_client_id();?>
        });
    </script>

    <div class="vk_button"></div>

    <div class="vk_content"></div>
</section>
</body>
</html>
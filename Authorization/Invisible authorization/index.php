<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Invisible Authorization demo</title>
    <script src="js/jquery.js"></script>
    <script src="https://vk.com/js/api/openapi.js?149" type="text/javascript"></script>
    <script src="js/vk.js"></script>
</head>
<body>
<section id="vk_module">
    <?php include_once 'php/VK_SETTINGS.php' ?>

    <script type="text/javascript">
        VK.init({
            apiId: <?php echo VKSETTINGS::get_client_id();?>
        });
    </script>

    <script>
        checkUserAuthorization();
    </script>
</section>
</body>
</html>
function checkUserAuthorization() {
    VK.Auth.getLoginStatus(function (response) {
        if(response.status === "connected") {
            if(userIsInDB(response.session)) {
                window.location = "http://nesterus.h1n.ru/VK/Authorization/Invisible%20authorization/main.php";
            } else {
                window.location = "http://nesterus.h1n.ru/VK/Authorization/Invisible%20authorization/login.php";
            }
        } else {
            window.location = "http://nesterus.h1n.ru/VK/Authorization/Invisible%20authorization/login.php";
        }
    });
}

function userIsInDB(session) {
    //alert(session.mid);
    //TODO: return users existence in DB
    return true;
}

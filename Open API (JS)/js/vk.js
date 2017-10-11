$(function () {
    if (!checkVkStatus()) {
        $(".vk_login").html('<input id=\"vk_login_button\" type=\"button\" value=\"Войти через VK\" onclick=\"login()\">');
    } else {
        $(".vk_login").html('<input id=\"vk_logout_button\" type=\"button\" value=\"Выйти из VK\" onclick=\"logout()\">');
    }

    $(".vk_status").html('<input id=\"vk_status_button\" type=\"button\" value=\"Информация о сессии\" onclick=\"getVkSessionInfo()\">');
});

function callServer(method, data, callback) {
    $.ajax({
        url: "php/vk_session.php",
        data: {
            method: method,
            data: data || {}
        },
        method: 'POST',
        success: function (response) {
            if (callback) {
                callback(response);
            }
        }
    });
}

function checkVkStatus() {
    var isConnected = false;

    VK.Auth.getLoginStatus(function (response) {
        //console.log(response);

        if (response.status === "connected") {
            console.log("connected to VK");
            isConnected = true;
        } else {
            console.log("not connected to VK");
            isConnected = false;
        }
    });

    return isConnected;
}

function login() {
    VK.Auth.login(function (response) {
            if (response.session) {
                checkSessionData(response.session);
                location.reload();
            } else {
                console.log("Вход отменён.");
            }
        },
        //See permissions list at https://vk.com/dev/permissions
        (   + 65536 //offline
            + 4194304)); //email
}

function logout() {
    VK.Auth.logout(function (response) {
        alert("Возвращайся снова!");
        //console.log(response);
    });

    delete sessionStorage.vk_client_id;
    location.reload();
}

function checkSessionData(vk_session) {
    callServer('check_session', vk_session, function (response) {
        //TODO: redraw UI depending on response
    });

    sessionStorage.vk_client_id = vk_session.user.id;
}

function getVkSessionInfo() {
    VK.Auth.getLoginStatus(function (response) {
        console.log(response);
    });
}
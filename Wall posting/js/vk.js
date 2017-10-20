$(function () {
    if (!checkVkStatus()) {
        $(".vk_button").html('<input id=\"vk_login_button\" type=\"button\" value=\"Войти через VK\" onclick=\"login()\">');
    } else {
        $(".vk_button").html('<input id=\"vk_logout_button\" type=\"button\" value=\"Выйти из VK\" onclick=\"logout()\">');
    }
});

function callServer(method, data, callback) {
    var methodResponse = {};

    $.ajax({
        url: "php/vk_session.php",
        data: {
            method: method,
            data: data || {}
        },
        method: 'POST',
        success: function (response) {
            methodResponse = response;
            if (callback) {
                callback(response);
            }
        }
    });

    return methodResponse;
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
        (+2 //friends
            + 4 //photos
            + 8192 // wall
            + 65536 //offline
            + 4194304)); //email
}

function logout() {
    VK.Auth.logout(function (response) {
        alert("Возвращайся снова!");
    });

    delete sessionStorage.vk_client_id;
    location.reload();
}

function checkSessionData(vk_session) {
    callServer('check_session', vk_session, function (response) {
        //console.log(response);
        //TODO: redraw UI depending on response
    });

    alert("Привет, " + vk_session.user.first_name + "!");
    sessionStorage.vk_client_id = vk_session.user.id;
}
$(function () {
    addVkLoginWidget();
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

function addVkLoginWidget() {
    VK.Widgets.Auth('vk_auth', {onAuth: function (vkResponse) {
        callServer('check_session', {
            uid: vkResponse.uid,
            hash: vkResponse.hash
        }, function (serverResponse) {
            console.log(serverResponse);
        });

        console.log(vkResponse);
    }});
}
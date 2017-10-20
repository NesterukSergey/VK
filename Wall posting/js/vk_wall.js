$(function () {
    addTestContent('.vk_content', 'img/test1.jpg');
});

function addTestContent(container, image) {
    $(container).html('<div class="test_post">' +
        '<img id="test_image" src="' + image + '">' +
        '<input id="test_text" type="text" placeholder="Ваш комментарий к посту..">' +
        '<input type="button" value="Поделиться" onclick="post()">' +
        '</div>');
}

function post () {
    sendPost({
        image: "../img/test1.jpg",
        photoCaption: "Описание фотографии",
        message: $('#test_text').val(),
        link: "http://nesterus.h1n.ru/"
    });
}

// sendPost(object) sends post on users VK wall
//@param image string - attached image path
//@param photoCaption string
//@param message string
//@param link string - link to your site, shown at the post's bottom
function sendPost(postData) {
    if (!checkVkStatus()) {
        alert("Сначала нужно зайти через VK");
    } else {

        VK.Api.call('photos.getWallUploadServer', {owner_id: sessionStorage.vk_client_id}, function (uploadServer) {
            callServer('upload_photo', {
                upload_server: uploadServer,
                image: postData.image
            }, function (response) {
                response = JSON.parse(response);

                VK.Api.call('photos.saveWallPhoto', {
                    user_id: sessionStorage.vk_client_id,
                    photo: response.photo,
                    server: response.server,
                    hash: response.hash,
                    caption: postData.photoCaption
                }, function (response) {
                    var post = {
                        owner_id: sessionStorage.vk_client_id,
                        message: postData.message || "",
                        attachments: response.response[0].id + ("," + postData.link)
                        //guid: UNIC_STRING
                    };

                    VK.Api.call('wall.post', post, function (postId) {
                        if (!postId.error) {
                            console.log(postId);
                        } else {
                            console.log("Post canceled");
                        }
                    });
                });
            });
        });
    }
}
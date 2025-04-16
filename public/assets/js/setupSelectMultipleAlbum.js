function multipleUploadImage() {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var files = evt.data.files.toArray(); // Lấy danh sách file được chọn
                files.forEach(function (file) {
                    appendImage(file.getUrl());
                });
            });

            finder.on('file:choose:resizedImage', function (evt) {
                appendImage(evt.data.resizedUrl);
            });
        }
    });
}

function appendImage(imageUrl) {
    console.log(imageUrl)
    const container = document.getElementById('imageContainer');

    let html = ''
    html += '<span class="image-wrapper">'
    html += '<img class="multipleUploadImage uploaded-image" id="ckAlbum" src="'+imageUrl+'" alt="'+imageUrl+'">'
    html += '<input type="hidden" name="album[]" value="'+imageUrl+'">'
    html += '<span class="delete-icon">x</span>'
    html += '</span>'

    $(container).append(html);
    $('.contentmultipleUploadImage').addClass('hidden');
    $( "#imageContainer" ).sortable();
}

deletePicture = () => {
    $(document).on('click', '.delete-icon', function () {
        let _this = $(this)
        _this.parents('.image-wrapper').remove()
        if ($('#imageContainer .image-wrapper').length === 0) {
            $('.contentmultipleUploadImage').removeClass('hidden');
        }
    })
}

const setupAlbum = () => {
    $('.multipleUploadImage').on('click', function () {
        multipleUploadImage();
    });
    deletePicture();
    if ($('#imageContainer .image-wrapper').length !== 0) {
        $('.contentmultipleUploadImage').addClass('hidden');
    }
}

$(document).ready(function (){
    setupAlbum();
})

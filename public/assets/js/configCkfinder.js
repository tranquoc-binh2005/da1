setupCkEditor = () => {
    document.querySelectorAll('.ck-editor').forEach((element) => {
        const height = element.getAttribute('data-height');

        ClassicEditor.create(element, {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            },
            enterMode: 2,
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'subscript',
                    'superscript',
                    'alignment',
                    '|',
                    'link',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    '|',
                    'CKFinder'
                ],
                shouldNotGroupWhenFull: true,
            },
            language: 'vi',
        })
            .then(editor => {
                window.editor = editor;
                CKFinder.setupCKEditor(editor);
                if (height) {
                    editor.ui.view.editable.element.style.height = `${height}px`; // Đảm bảo chiều cao được định dạng đúng
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
}

setupCkFinder = () => {
    $('.upload-image').on('click', function() {
        if($('.upload-image').length){
            $('.upload-image').each(function() {
                let _this = $(this)
                let id = _this.attr('id')
                selectFileWithCKFinder(id)
            })
        }
    })
}

function selectFileWithCKFinder(elementId) {
    CKFinder.popup({
        chooseFiles: true,
        chooseMultiple: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                let file = evt.data.files.first();
                let output = document.getElementById(elementId);
                output.value = file.getUrl();

                let ckAtavaImg = elementId + "Img"
                if(ckAtavaImg){
                    let imgElement = document.getElementById(ckAtavaImg);
                    if (imgElement) {
                        imgElement.src = output.value;
                    }
                }
            });

            finder.on('file:choose:resizedImage', function (evt) {
                let output = document.getElementById(elementId);
                output.value = evt.data.resizedUrl;
            });
        }
    });
}

uploadImageAvata = () => {
    $('.image-target').on('click', function () {
        if ($('.ck-target').length) {
            $('.ck-target').each(function() {
                let _this = $(this);
                let _id = _this.attr('id');
                selectFileWithCKFinder(_id);
            });
        } else {
            console.log('No ck-target elements found.');
        }
    });
}

$(document).ready(function () {
    setupCkEditor();
    setupCkFinder();
    uploadImageAvata();
    console.log(ClassicEditor);
})

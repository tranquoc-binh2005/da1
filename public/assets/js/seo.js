const seoPreview = () => {
    $('input[name=meta_title]').on('keyup', function () {
        let input = $(this)
        let value = input.val()
        $('.meta_title').html(`<h3>${value}</h3>`);
    })

    $('input[name=canonical]').css({
        'padding-left': parseInt($('.baseUrl').outerWidth()) - 4
    })

    $('input[name=canonical]').on('keyup', function() {
        let input = $(this)
        let value = input.val()
        $('.canonical').html(BASE_URL + value + SUFFIX)
    })

    $('textarea[name=meta_description]').on('keyup', function() {
        let input = $(this)
        let value = input.val()
        $('.meta_description').html(value)
    })
}


$(document).ready(function () {
    seoPreview()
})

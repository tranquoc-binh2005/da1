document.addEventListener("DOMContentLoaded", function() {
    const thumbnails = document.querySelectorAll('.image-grid img');
    const mainImage = document.getElementById('main-product-image');

    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            mainImage.src = this.src;
        });
    });
});

const formatCurrency = (number) => {
    if (!number || isNaN(number)) return '0đ';
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + 'đ';
}

const completeProduct = () => {
    $('.unitProduct').on('change', function () {
        let selectedOption = $(this).find('option:selected');
        let stock = selectedOption.data('stock');
        let price = selectedOption.data('price');
        let priceSale = selectedOption.data('price-sale');

        $('#current-price').text(priceSale && priceSale !== '0' ? formatCurrency(priceSale) : formatCurrency(price));
        $('#original-price').text(priceSale && priceSale !== '0' ? formatCurrency(price) : '');
        $('.input-number-product').val(1)

        if (stock > 0) {
            $('.status-stock-product').find('.origin').text('Còn hàng');
            $('.add-to-cart').prop('disabled', false);
        } else {
            $('.status-stock-product').find('.origin').text('Hết hàng');
            $('.add-to-cart').prop('disabled', true);
        }

        $('.input-number-product').attr('max', stock);
    });
};

const updateQuantityProduct = () => {
    $('.btn-apart-stock, .btn-add-stock').on('click', function () {
        let quantityInput = $(this).siblings('.input-number-product');
        let currentQuantity = parseInt(quantityInput.val());
        let maxStock = parseInt(quantityInput.attr('max'));

        if ($(this).hasClass('btn-apart-stock')) {
            if (currentQuantity > 1) {
                quantityInput.val(currentQuantity - 1);
            }
        } else if ($(this).hasClass('btn-add-stock')) {
            if (currentQuantity < maxStock) {
                quantityInput.val(currentQuantity + 1);
            } else {
                alert('Số lượng vượt quá số lượng hàng hiện có!');
            }
        }
    });
};


const sendRatingProduct = () => {
    $('.btn-send-rating-product').on('click', function (e) {
        e.preventDefault();

        let rating = $('input[name="rating"]:checked').val();
        let name = $('.comment-input').eq(0).val().trim();
        let email = $('.comment-input').eq(1).val().trim();
        let content = $('.comment-input').eq(2).val().trim();
        let productId = $(this).data('product');

        if (!rating) {
            alertWarning('Vui lòng chọn số sao đánh giá!');
            return;
        }
        if (name === '') {
            alertWarning('Vui lòng nhập họ và tên!');
            return;
        }
        if (email === '' || !validateEmail(email)) {
            alertWarning('Vui lòng nhập email hợp lệ!');
            return;
        }
        if (content === '') {
            alertWarning('Vui lòng nhập nội dung đánh giá!');
            return;
        }

        let data = {
            rating: rating,
            name: name,
            email: email,
            content: content,
            product_id: productId
        }

        $.ajax({
            url: '/ajax/rating',
            type: 'POST',
            data: { data: data },
            success: async function (response) {
                if (response.status === true) {
                    await alertSuccess('', response.message)
                    window.location.reload();
                }
                if(response.status === false && response.isLogin === false){
                    await alertWarning('', response.message)
                    window.location.href = '/dang-nhap'
                }
            },
            error: function (response) {
                $('.loader-container').hide();
                console.log(response.message)
            }
        });
    });
};
const validateEmail = (email) => {
    const regex = /^\S+@\S+\.\S+$/;
    return regex.test(email);
}

const textToRating = () => {
    $('input[name="rating"]').on('change', function () {
        const rating = $(this).val();
        let message = '';

        switch (rating) {
            case '1':
                message = 'Tệ';
                break;
            case '2':
                message = 'Cần cải thiện';
                break;
            case '3':
                message = 'Bình thường';
                break;
            case '4':
                message = 'Tốt';
                break;
            case '5':
                message = 'Tuyệt vời';
                break;
        }

        $('#text-rating').text('Đánh giá: ' + message);
    });
}

$(document).ready(function () {
    completeProduct();
    updateQuantityProduct();
    sendRatingProduct();
    textToRating();
});


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

$(document).ready(function () {
    completeProduct();
    updateQuantityProduct();
});


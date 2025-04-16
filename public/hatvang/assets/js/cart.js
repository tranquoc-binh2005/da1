const prepareDataProductAddCart = () => {
    $(document).on('click', '.add-to-cart', function () {

        let unitSelect = $(this).closest('div').find('.unitProduct');
        let selectedOption = unitSelect.find('option:selected');


        let data = {
            'price': trimPrice($('#current-price').text()),
            'unit': selectedOption.val(),
            'productId': $(this).data('product'),
            'quantity': $('.input-number-product').val(),
            'productVariantId': selectedOption.data('id')
        }

        addCart(data)
    });
}

const trimPrice = (string) => {
    return parseInt(string.replace(/\D/g, ''));
}

const addCart = (data) => {
    $.ajax({
        url: '/ajax/addCart',
        type: 'POST',
        data: {data: data},
        success:async function (response) {
            if(response.status === true) {
                $('#countCart').text(response.countCart.length)
                await alertSuccess('', response.message)
            } else {
                await alertError('', response.message)
                window.location.href = '/dang-nhap'
            }
        },
        error: function (response) {
            $('.loader-container').hide();
            console.log(response.message)
        }
    });
}

const handleQuantityChangeCart = () => {
    $(document).on('click', '.btn-add-product-item, .btn-apart-product-item', async function () {
        let isIncrease = $(this).hasClass('btn-add-product-item');
        let quantityInput = $(this).siblings('.quantity-product-item');
        let currentQuantity = parseInt(quantityInput.val());

        let newQuantity = isIncrease ? currentQuantity + 1 : currentQuantity - 1;

        if (newQuantity < 1) {
            await alertError('', 'Số lượng không được nhỏ hơn 1');
            return;
        }

        quantityInput.val(newQuantity);

        let data = {
            'id': quantityInput.data('cart'),
            'price': quantityInput.data('price'),
            'quantity': newQuantity
        };

        $.ajax({
            url: '/ajax/updateCart',
            type: 'POST',
            data: {data: data},
            success: async function (response) {
                $('.tmp-total-cart').text(formatCurrency(response.total))
                $('.total-cart').text(formatCurrency(response.total))
                $(quantityInput).closest('.quantity').siblings('.total-price').text(formatCurrency(data.price * data.quantity));
            },
            error: function (response) {
                $('.loader-container').hide();
                console.log(response.message);
            }
        });
    });
}

const removeCartItem = () => {
    $(document).on('click', '.remove-cart-item', function () {
        let cartId = $(this).data('cart')
        $.ajax({
            url: '/ajax/removeCart',
            type: 'POST',
            data: {cartId: cartId},
            success: async function (response) {
                $('.left-cart').empty();

                if (response.cart.length > 0) {
                    $('.left-cart').append(`<h2 class="count-cart">Giỏ hàng (${response.cart.length})</h2>`);
                } else {
                    $('.left-cart').append(`<h2 class="count-cart">Giỏ hàng (0)</h2>
                     <div class="cart-item">Opps, giỏ hàng đang rỗng</div>`);
                }

                response.cart.map(cartItem => {
                    $('.left-cart').append(templateCartItemHtml(cartItem));
                });

                $('.tmp-total-cart').text(formatCurrency(response.totalCart));
                $('.total-cart').text(formatCurrency(response.totalCart));

                $('.left-cart').append(` <button class="back-btn">
                                            <a href="/san-pham">←</a>
                                        </button>`)

                await alertSuccess('', response.message);
            },
            error: function (response) {
                $('.loader-container').hide();
                console.log(response.message);
            }
        });
    })
}

const templateCartItemHtml = (cartItem, countCart) => {
    return `
                    <div class="cart-item">
                        <img src="${cartItem.productItem.image}" alt="${cartItem.productItem.name}">
                        <div class="item-details">
                            <p>${cartItem.productItem.name}</p>
                            <span class="price">
                                ${formatCurrency(cartItem.price)}
                                (${cartItem.unit})
                            </span>
                        </div>
                        <div class="quantity">
                            <button class="btn-apart-product-item">-</button>
                            <input value="${cartItem.quantity}" type="number" data-price="${cartItem.price}" data-cart="${cartItem.id}" class="quantity-product-item">
                            <button class="btn-add-product-item">+</button>
                        </div>
                        <span class="total-price">
                            ${formatCurrency(cartItem.total_price)}
                        </span>
                        <div data-cart="${cartItem.id}" class="remove-cart-item">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>`
}

$(document).ready(function () {
    prepareDataProductAddCart();
    handleQuantityChangeCart();
    removeCartItem();
});
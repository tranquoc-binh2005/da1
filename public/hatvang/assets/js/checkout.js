const changeAddressCheckout = () => {
    $('#confirm-address').on('click', function () {
        const addressId = $('.checkout-modal-body input[type="radio"][name="address-shipping"]:checked').val();

        $.ajax({
            url: '/ajax/changeAddressShopping',
            type: 'POST',
            data: {addressId: addressId},
            success: function (response) {
                let default_address = $('#default-address');
                default_address.empty();

                let html = loadHtmlAddressDefault(response.address)
                default_address.html(html);
                $('#address-modal').css('display', 'none');
            },
            error: function (response) {
                console.log(response.message);
            }
        });
    });
}

const loadHtmlAddressDefault = (address) => {
    return `<p id="default-address">
                Khách hàng:
                <strong>
                    ${address.name}
                    ${formatPhoneToVN(address.phone)}
                </strong>
                ${address.address}
                <button type="button" class="btn-confirm" id="change-address-btn">Thay đổi</button>
            </p>`
}

formatPhoneToVN = phone => {
    const digits = phone.replace(/\D/g, '');

    let formatted = digits;
    if (digits.startsWith('0')) formatted = '(+84) ' + digits.substring(1);

    return formatted;
}


const toggleChangeAddress = () => {
    $(document).on('click', '#change-address-btn', function () {
        $('#address-modal').css('display', 'flex');
    })

    $(document).on('click', '#cancel-modal', function () {
        $('#address-modal').css('display', 'none');
    })
}

const checkIsPaymentMethod = () => {
    $('.btn-checkout').on('click', async function (e) {
        const isChecked = $('input[name="payment_method"]:checked').length > 0;

        if (!isChecked) {
            e.preventDefault();
            await alertWarning('', 'Vui lòng chọn phương thức thanh toán')
        }
    });
};

$(document).ready(function () {
    toggleChangeAddress();
    changeAddressCheckout();
    checkIsPaymentMethod();
});

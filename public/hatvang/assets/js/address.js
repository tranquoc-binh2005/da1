const saveAddressShopping = () => {
    $('.btn-save-address-shopping').on('click', function () {
        const result = checkAddressValidation();

        $('.error-message').text('').hide();

        if (!result.valid) {
            $(`.error-message-${result.field}`).text(result.message).show();
            return;
        }

        let data = prepareAddressData();
        const addressId = $('#addressId').val();
        const url = addressId ? '/ajax/updateAddressShopping' : '/ajax/saveAddressShopping';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {data: data, addressId: addressId},
            success: async function (response) {
                if(response.status === true) await alertSuccess('', response.message);
                resetModalFields();
                $('.main-address-container').empty();
                response.data.forEach(item => {
                    const html = loadHtmlAddressShopping(item);
                    $('.main-address-container').append(html);
                });
                removeAddressShopping();
                showModalUpdateAddressShopping();
            },
            error: async function (response) {
                await alertError('', response.message);
            }
        });
    });
}

const prepareAddressData = () => {
    return {
        fullName: $('.address-shopping-name').val().trim(),
        phone: $('.address-shopping-phone').val().trim(),
        address: $('.address-shopping-address').val().trim(),
        isDefault: $('.address-shopping-isDefault').is(':checked') ? 1 : 2
    };
}

const checkAddressValidation = () => {
    const data = prepareAddressData();

    const phoneRegex = /^(0|\+84)[0-9]{9}$/;
    if (!data.fullName) return { valid: false, field: 'name', message: 'Vui lòng nhập họ và tên' };
    if (!phoneRegex.test(data.phone)) return { valid: false, field: 'phone', message: 'Số điện thoại không hợp lệ' };
    if (!data.address)  return { valid: false, field: 'address', message: 'Vui lòng nhập địa chỉ' };

    return { valid: true };
}

const removeErrorValidation = () => {
    $('#fullName, #phone, #address').on('input', function () {
        const id = $(this).attr('id');

        const errorClass = `.error-message-${id === 'fullName' ? 'name' : id}`;

        $(errorClass).text('').hide();
    });
};

window.resetModalFields = function() {
    $('#fullName, #phone, #address, #addressId').val('');
    $('#add-default').prop('checked', false);
    $('#addressModal .address-modal-title').text('Thêm địa chỉ mới');

    $('.error-message').text('').hide();
}

window.openModal = function() {
    document.getElementById("addressModal").style.display = "flex";
}

window.closeModal = function() {
    document.getElementById("addressModal").style.display = "none";
}
const resetModalFields = () => {
    window.resetModalFields();
    closeModal();
}

const removeAddressShopping = () => {
    $('.address-btn-delete').on('click', async function () {
        const id = $(this).data('id');

        Swal.fire({
            title: "Bạn có chắc không?",
            text: "Hành động này không thể hoàn tác!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng ý"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/ajax/removeAddressShopping',
                    method: 'POST',
                    data: {id: id},
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === true) alertSuccess(response.message)
                        $('.main-address-container').empty();
                        response.data.forEach(item => {
                            const html = loadHtmlAddressShopping(item);
                            $('.main-address-container').append(html);
                        });
                        removeAddressShopping();
                        showModalUpdateAddressShopping();
                    },
                    error: function(response) {
                        alertSuccess(response.message)
                    }
                });
            }
        });
    })
}

const loadHtmlAddressShopping = (data) => {
    return `<div class="address-item">
                <div class="address-name">
                    ${data.name}
                    ${data.isDefault === 1 ? '<span class="address-default">Mặc định</span>' : ''}
                </div>
                <div class="address-detail address-detail-address">${data.address}</div>
                <div class="address-detail address-detail-phone">${data.phone}</div>
                <div class="address-actions">
                    <button data-id="${data.id}" class="address-btn-update">Cập nhật</button>
                    <button data-id="${data.id}" class="address-btn-delete">Xóa</button>
                </div>
            </div>`;
}

const showModalUpdateAddressShopping = () => {
    $('.address-btn-update').on('click', function () {
        const id = $(this).data('id');
        loadDataAddressShoppingUpdate(id);
    })
}

const loadDataAddressShoppingUpdate = (id) => {
    $.ajax({
        url: '/ajax/detailAddressShopping',
        type: 'POST',
        data: {id: id},
        success: async function (response) {
            $('#addressModal .address-modal-title').text('Cập nhật địa chỉ');
            $('#fullName').val(response.data.name);
            $('#phone').val(response.data.phone);
            $('#address').val(response.data.address);
            $('#add-default').prop('checked', response.data.isDefault == 1);
            $('#addressId').val(id);
            
            openModal();
        },
        error: async function (response) {
            await alertError('', response.message);
        }
    });
}

$(document).ready(function () {
    saveAddressShopping();
    removeErrorValidation();
    removeAddressShopping();
    showModalUpdateAddressShopping();
});
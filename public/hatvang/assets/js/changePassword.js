const changePassword = () => {
    $('.submit-button-reset-password').on('click', function () {
        const checkResult = checkPasswordConfirm();

        $('.error-message').text('').hide();

        if (!checkResult.valid) {
            $(`.error-message-${checkResult.field}`).text(checkResult.message).show();
            return;
        }
        checkIsPasswordAndSubmit();
    });
}
const checkIsPasswordAndSubmit = () => {
    let data = prepareDataPassword()

    $.ajax({
        url: '/ajax/checkIsPassword',
        type: 'POST',
        data: {data: data},
        success: async function (response) {
            if(response.status === false) {
                $('.error-message-current-password').text(response.message).show();
                return;
            }
            if(response.status === true) await alertSuccess('', response.message);
            resetPasswordFields()
        },
        error: async function (response) {
            await alertError('', response.message);
        }
    });
}

const checkPasswordConfirm = () => {
    let data = prepareDataPassword();

    if (!data.currentPassword) return { valid: false, field: 'current-password', message: 'Vui lòng nhập mật khẩu hiện tại' };
    if (data.newPassword.length < 8 || data.confirmPassword.length < 8) return { valid: false, field: 'new-password', message: 'Mật khẩu phải có ít nhất 8 ký tự' };
    if (data.newPassword !== data.confirmPassword) return { valid: false, field: 'confirm-password', message: 'Mật khẩu xác nhận không khớp' };

    return { valid: true };
}

const prepareDataPassword = () => {
    return {
        'currentPassword': $('#current-password').val().trim(),
        'newPassword': $('#new-password').val().trim(),
        'confirmPassword': $('#confirm-password').val().trim()
    }
}

const resetPasswordFields = () => {
    $('#current-password').val('');
    $('#new-password').val('');
    $('#confirm-password').val('');
}

const hideErrorMessage = () => {
    $('#current-password, #new-password, #confirm-password').on('input', function () {
        const id = $(this).attr('id');
        $(`.error-message-${id}`).text('').hide();
    });
}

$(document).ready(function () {
    changePassword();
    hideErrorMessage();
});
const callUpdateProfile = () => {
    $(document).on('click', '.btn-update-profile', function () {
        $('.profile-form input, .profile-form textarea').prop('readonly', false);

        $('.btn-update-profile').addClass('hidden');
        $('.btn-save-profile').removeClass('hidden');
    });
}

const saveProfile = () => {
    $(document).on('click', '.btn-save-profile',function () {
        $('.profile-form input, .profile-form textarea').prop('readonly', true);

        $('.btn-save-profile').addClass('hidden');
        $('.btn-update-profile').removeClass('hidden');

        let data = {
            'name': $('#name').val(),
            'email': $('#email').val(),
            'phone': $('#phone').val(),
            'address': $('#address').val(),
            'birthday': $('#birthday').val(),
            'bio': $('#bio').val(),
        }

        $.ajax({
            url: '/ajax/updateProfileUser',
            type: 'POST',
            data: {data: data},
            success: async function (response) {
                await alertSuccess('', response.message);
            },
            error: async function (response) {
                $('.loader-container').hide();
                await alertError('', response.message);
            }
        });
    });
}

const changeTextName = () => {
    $('#name').on('keyup change', function (){
        let text = $(this).val();
        $('.user-name').text(text)
    })
}

$(document).ready(function () {
    callUpdateProfile();
    saveProfile();
    changeTextName();
});

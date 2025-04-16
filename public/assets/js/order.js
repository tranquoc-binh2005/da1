const checkAll = () => {
    $('#checkAll').on('change', function () {
        $('.checkbox').prop('checked', $(this).is(':checked'));
    });

    $(document).on('change', '.checkbox', function () {
        const total = $('.checkbox').length;
        const checked = $('.checkbox:checked').length;

        $('#checkAll').prop('checked', total === checked);
    });

    const total = $('.checkbox').length;
    const checked = $('.checkbox:checked').length;
    $('#checkAll').prop('checked', total > 0 && total === checked);
};


const confirmOrder = () => {
    $('.confirm-order').on('click', function () {
        const data = $('.checkbox:checked').map(function () {
            return {
                id: $(this).data('id'),
                status: $(this).data('status')
            };
        }).get();

        $.ajax({
            url: '/ajax/bulkChangeStatusOrder',
            type: 'POST',
            data: {data: data},
            success: function (response) {
                window.location.reload();
            },
            error: function (response) {
                console.log(response)
            }
        });
    })
}

$(document).ready(function () {
    checkAll();
    confirmOrder();
});
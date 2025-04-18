const cancelOrder = () => {
    $('.btn-cancel-order').on('click', function () {
        let orderId = $(this).data('id');

        Swal.fire({
            title: 'Bạn có chắc muốn hủy đơn hàng này không?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/ajax/cancelOrder',
                    type: 'POST',
                    data: {orderId: orderId},
                    success: async function (response) {
                        await alertSuccess('', response.message);
                        location.reload();
                    },
                    error: async function (response) {
                        await alertError('', response.message);
                    }
                });
            }
        });
    });
}

$(document).ready(function () {
    cancelOrder();
});
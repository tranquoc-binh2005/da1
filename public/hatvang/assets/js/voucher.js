const checkIsVoucher = (voucher) => {
    $('.span-error-voucher').text('');
    $('.voucher-name').text('-');
    $('.voucher-discount').text('-');

    const tmpTotal = parseInt($('.tmp-total-cart').text().replace(/[^\d]/g, ''));
    $('.total-cart').text(new Intl.NumberFormat().format(tmpTotal) + 'đ');

    if (voucher === '') {
        $('.span-error-voucher').text('Bạn chưa nhập voucher');
        return;
    }

    $.ajax({
        url: '/ajax/checkIsVoucher',
        type: 'POST',
        data: {voucher: voucher},
        success: function (response) {
            if(response.status === false){
                $('.span-error-voucher').text('Voucher không tồn tại, vui lòng thử lại sau');
                return;
            }

            const data = response.data;

            if(data === undefined) return
            const tmpTotal = parseInt($('.tmp-total-cart').text().replace(/[^\d]/g, ''));

            console.log(data)
            if(tmpTotal < data.min){
                $('.span-error-voucher').text(`Đơn hàng phải tối thiểu ${new Intl.NumberFormat().format(data.min)}đ để sử dụng mã này`);
                return;
            }

            let discountAmount = Math.floor(tmpTotal * data.value / 100);

            if(discountAmount > data.max){
                discountAmount = data.max;
            }

            $('.span-error-voucher').text('');
            $('.voucher-name').text(data.name);
            $('.voucher-discount').text('-' + new Intl.NumberFormat().format(discountAmount) + 'đ');
            $('.total-cart').text(new Intl.NumberFormat().format(tmpTotal - discountAmount) + 'đ');
        },
        error: function (response) {
            $('.loader-container').hide();
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    });
}


const applyVoucher = () => {
    $('.btn-apply-voucher').on('click', function (){
        let voucher = $('.input-apply-voucher').val().trim();
        checkIsVoucher(voucher);
    })
}


$(document).ready(function () {
    applyVoucher();
});

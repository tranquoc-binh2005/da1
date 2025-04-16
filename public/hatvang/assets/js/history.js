const callHistoryOrderByStatus = () => {
    $('.order-history__status-bar__item').on('click', function () {
        let statusId = $(this).data('value')

        $('.order-history__status-bar__item').removeClass('click-active');

        $(this).addClass('click-active');

        $.ajax({
            url: '/ajax/callHistoryOrderByStatus',
            type: 'POST',
            data: {statusId: statusId},
            success: async function (response) {
                if (response.status && Array.isArray(response.data) && response.data.length > 0) {
                    $('.empty-cart').addClass('hidden');

                    let orderHistoryList = $('.order-history__list');
                    let html = renderOrders(response.data);

                    orderHistoryList.empty();
                    orderHistoryList.html(html);
                } else {
                    $('.order-history__list').empty()
                    $('.empty-cart').removeClass('hidden');
                }
            },
            error: async function (response) {
                $('.loader-container').hide();
                await alertError('', response.message);
            }
        });
    })
}

const renderOrders = (orders) => {
    let html = '';

    orders.forEach(order => {
        html += `<div class="order-history__order">`;

        order.detail.forEach(detail => {
            html += `
                <div class="order-history__order__item">
                    <img src="${detail.image}" alt="${detail.name}" class="order-history__order__item__image">
                    <div class="order-history__order__item__details">
                        <p class="order-history__order__item__name">${detail.name}</p>
                        <p class="order-history__order__item__price">Giá: ${formatCurrencyVN(detail.price)}</p>
                    </div>
                    <div class="order-history__order__item__quantity">x${detail.quantity}</div>
                    <div class="order-history__order__item__total">${formatCurrencyVN(detail.price)}</div>
                </div>
            `;
        });

        let statusClass = '';
        let statusText = '';

        switch (order.status_order_id) {
            case 1:
                statusClass = 'order-history__order__footer__button--awaiting';
                statusText = 'Chờ xác nhận';
                break;
            case 2:
                statusClass = 'order-history__order__footer__button--processing';
                statusText = 'Đang xử lý';
                break;
            case 3:
                statusClass = 'order-history__order__footer__button--success';
                statusText = 'Thành công';
                break;
            case 4:
                statusClass = 'order-history__order__footer__button--cencel';
                statusText = 'Đã huỷ';
                break;
        }

        html += `
            <div class="order-history__order__footer">
                <button class="order-history__order__footer__button ${statusClass}">${statusText}</button>
                <a href="/don-hang/chi-tiet-don-hang/${order.id}" class="order-history__order__footer__button--view">Xem đơn hàng</a>
                <span class="order-history__order__footer__total">Tổng: ${formatCurrencyVN(order.total_price)}</span>
            </div>
        </div>`;
    });

    return html;
};


$(document).ready(function () {
    callHistoryOrderByStatus();
});


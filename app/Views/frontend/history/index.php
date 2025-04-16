<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="order-history container">
    <div class="main-title mt-20">
        <h1 class="section-title">Lịch sử mua hàng</h1>
    </div>

    <div class="order-history__status-bar <?= !empty($dataOrder) ? '' : 'hidden' ?>">
        <span class="order-history__status-bar__item click-active">Tất cả</span>
        <?php foreach ($dataStatusOrder as $status) : ?>
            <span class="order-history__status-bar__item" data-value="<?=$status['value']?>"><?=$status['name']?></span>
        <?php endforeach;?>
    </div>
    <div class="empty-cart <?= !empty($dataOrder) ? 'hidden' : '' ?>">
        <h3>Không có đơn hàng nào gần đây!</h3>
        <p>Thêm <a class="text-highlight" href="/san-pham">sản phẩm</a> vào giỏ hàng và quay lại trang thanh toán nha bạn</p>
        <p>
            <img src="/public/hatvang/assets/img/empty-cart.webp" alt="">
        </p>
    </div>
    <div class="order-history__list">
        <?php foreach ($dataOrder as $order):?>
            <div class="order-history__order">
                <?php foreach ($order['detail'] as $detailOrder):?>
                    <div class="order-history__order__item">
                        <img src="<?=$detailOrder['image']?>" alt="<?=$detailOrder['name']?>" class="order-history__order__item__image">
                        <div class="order-history__order__item__details">
                            <p class="order-history__order__item__name"><?=$detailOrder['name']?></p>
                            <p class="order-history__order__item__price">Giá: <?=formatCurrencyVN($detailOrder['price'])?></p>
                        </div>
                        <div class="order-history__order__item__quantity">x<?=$detailOrder['quantity']?></div>
                        <div class="order-history__order__item__total"><?=formatCurrencyVN($detailOrder['price'])?></div>
                    </div>
                <?php endforeach;?>
                <div class="order-history__order__footer">
                    <?php
                    $statusClass = match ($order['status_order_id']) {
                        1 => 'order-history__order__footer__button--awaiting',
                        2 => 'order-history__order__footer__button--processing',
                        3 => 'order-history__order__footer__button--success',
                        4 => 'order-history__order__footer__button--cencel'
                    };
                    $statusText = match ($order['status_order_id']) {
                        1 => 'Chờ xác nhận',
                        2 => 'Đang xử lý',
                        3 => 'Thành công',
                        4 => 'Đã huỷ',
                    }
                    ?>
                    <button class="order-history__order__footer__button <?=$statusClass?>"><?=$statusText?></button>
                    <a href="/don-hang/chi-tiet-don-hang/<?=$order['id']?>" class="order-history__order__footer__button--view">Xem đơn hàng</a>
                    <span class="order-history__order__footer__total">Tổng: <?=formatCurrencyVN($order['total_price'])?></span>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
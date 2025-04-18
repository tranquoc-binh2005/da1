<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="container">
    <div class="main-title mt-20">
        <h1 class="section-title">Chi tiết đơn hàng</h1>
    </div>
    <div class="order-details__info">
        <div class="order-details__info__item">
            <span class="order-details__info__label">Mã đơn hàng</span>
            <span class="order-details__info__value">#<?=$dataDetailOrder['code']?></span>
        </div>
        <div class="order-details__info__item">
            <span class="order-details__info__label">Tổng tiền</span>
            <span class="order-details__info__value"><?=formatCurrencyVN($dataDetailOrder['total_price'])?></span>
        </div>
        <div class="order-details__info__item">
            <span class="order-details__info__label">Thời gian</span>
            <span class="order-details__info__value"><?=formatDateTimeVN($dataDetailOrder['created_at'])?></span>
        </div>
        <div class="order-details__info__item">
            <span class="order-details__info__label">Phương thức thanh toán</span>
            <?php
            $paymentMethod = match ($dataDetailOrder['payment_method']) {
                'cod' => 'Thanh toán khi nhận hàng',
                'paypal' => 'Thanh toán PayPal'
            };
            ?>
            <span class="order-details__info__value"><?=$paymentMethod?></span>
        </div>
        <div class="order-details__info__item">
            <span class="order-details__info__label">Thông tin người nhận</span>
            <span class="order-details__info__value"><?=$dataDetailOrder['address_shopping_name'] . '  '.formatPhoneToVN($dataDetailOrder['address_shopping_phone'])?></span>
        </div>
        <div class="order-details__info__item">
            <span class="order-details__info__label">Địa chỉ người nhận</span>
            <span class="order-details__info__value"><?=$dataDetailOrder['address_shopping_address']?></span>
        </div>
    </div>

    <div class="order-details__content">
        <div class="order-details__content__products">
            <h2 class="order-details__content__products__title">Sản phẩm trong đơn hàng</h2>
            <div class="order-details__content__products__list">
                <?php foreach ($dataDetailOrder['detail'] as $item):?>
                <div class="order-details__content__products__item">
                    <img src="<?=$item['image']?>" alt="<?=$item['name']?>" class="order-details__content__products__item__image">
                    <div class="order-details__content__products__item__info">
                        <h3 class="order-details__content__products__item__name"><?=$item['name']?></h3>
                        <p class="order-details__content__products__item__description"><?=$item['description']?></p>
                        <p class="order-details__content__products__item__quantity">Số lượng: <?=$item['quantity']?></p>
                        <p class="order-details__content__products__item__price"><?=formatCurrencyVN($item['price'])?></p>
                    </div>
                </div>
                <?php endforeach;?>
            </div>

            <a href="/don-hang" class="btn btn-primary">Quay lại</a>
        </div>
        <div class="order-details__content__status">
            <h2 class="order-details__content__status__title">Trạng thái đơn hàng</h2>
            <p class="order-details__content__status__date">Dự kiến giao hàng vào ngày 28/02</p>
            <ul class="order-details__content__status__list">
                <?php
                $steps = getOrderStatusSteps($dataDetailOrder['status_order_id']);
                $current = $dataDetailOrder['status_order_id'];

                foreach ($steps as $step):
                    $class = getStatusClass($current, $step['id']);
                    ?>
                    <li class="order-details__content__status__item <?= $class ?>">
                        <span class="order-details__content__status__item__icon">
                            <?= $class === 'order-details__content__status__item--completed' ? '✔' : ($class === 'order-details__content__status__item--current' ? '●' : '○') ?>
                        </span>
                        <?= $step['label'] ?>
                        <?php if (!empty($step['note'])): ?>
                            <p class="order-details__content__status__item__note"><?= $step['note'] ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="btn btn-second btn-cancel-order
                <?=($dataDetailOrder['status_order_id'] <= 1 && $dataDetailOrder['payment_method'] === 'cod') ? '' : 'hidden'?>"
               data-id="<?=$dataDetailOrder['id']?>"
            >Hủy đơn</a>
        </div>
    </div>
</div>

<?php
function getOrderStatusSteps(int $status_order_id): array {
    $steps = [
        ['label' => 'Đơn hàng đã được đặt thành công', 'note' => '', 'id' => 0],
        ['label' => 'Đơn hàng đang chờ xác nhận', 'note' => '', 'id' => 1],
    ];

    if ($status_order_id === 4) {
        $steps[] = ['label' => 'Đơn hàng đã bị hủy', 'note' => '', 'id' => 4];
    } else {
        $steps[] = [
            'label' => 'Đơn hàng đang được xử lý',
            'note' => ($status_order_id >= 2 && $status_order_id !== 4) ? 'Đơn vị vận chuyển đang lấy hàng' : '',
            'id' => 2
        ];
        $steps[] = ['label' => 'Đơn hàng đã giao thành công', 'note' => '', 'id' => 3];
    }
    return $steps;
}


function getStatusClass(int $currentStatus, int $stepId): string {
    if ($stepId < $currentStatus) return 'order-details__content__status__item--completed';
    if ($stepId === $currentStatus) return 'order-details__content__status__item--current';
    return '';
}
?>


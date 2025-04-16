<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<form action="/xu-ly-thanh-toan" method="post">
    <div class="checkout-container container mt-20">
        <div class="checkout-form">
            <div class="main-title">
                <h1 class="section-title">Địa chỉ nhận hàng</h1>
            </div>

            <div class="checkout-address">
                <label class="address-label">Địa chỉ</label>

                <?php
                $address = $_SESSION['addressDefault'] ?? $dataAddressShoppingDefault ?? null;

                if ($address): ?>
                    <div class="address-display mb-20">
                        <p id="default-address">
                            Khách hàng:
                            <strong>
                                <?= $address['name'] ?? '' ?>
                                <?= formatPhoneToVN($address['phone'] ?? '') ?>
                            </strong>
                            <?= $address['address'] ?? '' ?>
                            <button type="button" class="btn-confirm" id="change-address-btn">Thay đổi</button>
                        </p>
                        <input type="hidden" name="address_shopping_id" value="<?= $address['id'] ?>">
                    </div>
                <?php else: ?>
                    <div class="address-edit">
                        <input type="text" name="name" id="fullname-input" value="<?= $_SESSION['user']['name'] ?? '' ?>" class="checkout-input" placeholder="Họ tên người nhận" />
                        <input type="number" name="phone" id="phone-input" value="<?= $_SESSION['user']['phone'] ?? '' ?>" class="checkout-input" placeholder="Số điện thoại" />
                        <textarea id="address-input" name="address" class="checkout-input" placeholder="Địa chỉ giao hàng"></textarea>
                    </div>
                <?php endif; ?>

            </div>

            <textarea class="checkout-textarea" name="description" placeholder="Ghi chú"></textarea>

            <div class="main-title">
                <h1 class="section-title">Phương thức thanh toán</h1>
            </div>

            <div class="checkout-payment-method">
                <label>
                    <input type="radio" name="payment_method" value="cod" /> COD (Thanh toán khi nhận được hàng)
                </label>
            </div>

            <div class="checkout-payment-method">
                <label>
                    <input type="radio" name="payment_method" value="paypal" /> Thanh toán qua VNPAY
                </label>
            </div>

            <div class="checkout-payment-method">
                <label>
                    <input type="radio" name="payment_method" value="momo" /> Thanh toán qua Momo
                </label>
            </div>

        </div>

        <div class="checkout-summary">
            <h3>Tổng tiền</h3>
            <div class="summary-row">
                <span>Tạm tính</span>
                <span>
                <?=formatCurrencyVN($dataCart['total'])?>
            </span>
            </div>
            <div class="summary-row">
            <span>
                Voucher <?=($dataVoucher['voucher']) ?? ''?> <br>
                <?php
                if(isset($dataVoucher['errors'])){
                    foreach ($dataVoucher['errors'] as $error) {
                        echo '<span class="text-danger">'.$error.'</span>';
                    }
                }
                ?>
            </span>
                <span>-<?=formatCurrencyVN($dataVoucher['discount_amount'] ?? 0)?></span>
            </div>
            <div class="summary-row">
                <span>Phí giao hàng</span>
                <span>
                <?=formatCurrencyVN(30000)?>
            </span>
            </div>
            <div class="summary-row">
                <span>Tổng giảm</span>
                <span>-<?=formatCurrencyVN($dataVoucher['discount_amount'] ?? 0)?></span>
            </div>
            <hr />
            <div class="summary-row total">
                <span>Tổng</span>
                <span><?= formatCurrencyVN(($dataVoucher['total_after_discount'] ?? $dataCart['total']) + 30000) ?></span>
                <input type="hidden" name="total_price" value="<?= ($dataVoucher['total_after_discount'] ?? $dataCart['total']) + 30000 ?>">
            </div>
            <button class="btn btn-primary btn-checkout">Thanh toán</button>
        </div>
    </div>
</form>

<div class="checkout-modal-overlay" id="address-modal" style="display: none;">
    <div class="checkout-modal">
        <div class="checkout-modal-header">
            <h3>Địa Chỉ Của Tôi</h3>
        </div>
        <div class="checkout-modal-body">
            <div class="checkout-modal-address">
                <?php
                $defaultAddressId = $_SESSION['addressDefault']['id'] ?? null;
                ?>

                <?php if (isset($dataAddressShoppingOption)): ?>
                    <?php foreach ($dataAddressShoppingOption as $address): ?>
                        <label class="checkout-address-option">
                            <input type="radio" name="address-shipping" value="<?=$address['id']?>"
                                <?= ($address['id'] == $defaultAddressId || $address['isDefault'] === 1) ? 'checked' : '' ?>
                            >
                            <div class="checkout-address-info">
                                <div class="checkout-address-name">
                                    <strong><?=$address['name']?></strong>
                                    <span><?=formatPhoneToVN($address['phone'])?></span>
                                    <?=($address['isDefault'] === 1) ? '<span class="checkout-default-tag address-default">Mặc định</span>' : ''?>
                                </div>
                                <div class="checkout-address-detail mt-10">
                                    <?=$address['address']?>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="checkout-modal-footer">
            <button id="cancel-modal" class="btn-cancel">Hủy</button>
            <button id="confirm-address" class="btn-confirm">Xác nhận</button>
        </div>
    </div>
</div>
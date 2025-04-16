<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="container mt-20">
    <div class="cart">
        <div class="left-cart">
            <h2 class="count-cart">Giỏ hàng (<?=isset($dataCart['cart']) ? count($dataCart['cart']) : 0?>)</h2>
            <?php if(empty($dataCart['cart'])){?>
            <div class="cart-item">
                opps, gio hang dang rong
            </div>
            <?php }?>
            <?php if(!empty($dataCart['cart'])){?>
                <?php foreach ($dataCart['cart'] as $cart){?>
                    <div class="cart-item">
                        <img src="<?=$cart['productItem']['image']?>" alt="<?=$cart['productItem']['image']?>">
                        <div class="item-details">
                            <p><?=$cart['productItem']['name']?></p>
                            <span class="price">
                                <?= number_format($cart['price'], 0, ',', '.') . 'đ' ?>
                                (<?=$cart['unit']?>)
                            </span>
                        </div>
                        <div class="quantity">
                            <button class="btn-apart-product-item">-</button>
                            <input value="<?=$cart['quantity']?>" type="number" data-price="<?=$cart['price']?>" data-cart="<?=$cart['id']?>" class="quantity-product-item">
                            <button class="btn-add-product-item">+</button>
                        </div>
                        <span class="total-price">
                            <?= number_format($cart['total_price'], 0, ',', '.') . 'đ' ?>
                        </span>
                        <div data-cart="<?=$cart['id']?>" class="remove-cart-item">
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
            <?php }}?>
            <button class="back-btn">
                <a href="/san-pham">←</a>
            </button>
        </div>
    <div class="right-cart">
        <form action="/thanh-toan" method="post">
            <div class="summary">
                <h2>Tổng tiền</h2>
                <div class="summary-item">
                    <span>Tạm tính</span>
                    <span class="tmp-total-cart">
                    <?= number_format($dataCart['total'], 0, ',', '.') . 'đ' ?>
                </span>
                </div>
                <div class="summary-item">
                    <span>Voucher</span>
                    <span class="voucher-name">-</span>
                </div>
                <div class="summary-item">
                    <span>Tổng giảm</span>
                    <span class="voucher-discount">-</span>
                </div>
                <div class="summary-item total">
                    <span>Tổng</span>
                    <span class="total-cart">
                    <?= number_format($dataCart['total'], 0, ',', '.') . 'đ' ?>
                </span>
                </div>
                <button class="btn btn-primary btn-checkout-cart">Tiếp tục</button>
            </div>
            <div class="voucher-container mt-20">
                <div class="f-voucher">
                    <input type="text" name="voucher" class="input-apply-voucher" id="">
                    <span class="text-danger span-error-voucher"></span>
                </div>
                <div>
                    <button type="button" class="btn-apply-voucher">Áp dụng</button>
                </div>
            </div>
        </form>
    </div>
</div>
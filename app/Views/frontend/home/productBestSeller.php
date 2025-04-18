<section class="container  mt-20">
    <h1 class="section-title">Sản phẩm bán chạy</h1>

    <div class="main-content">
        <div class="banner">
            <img src="/public/hatvang/assets/img/group-6.png" alt="Banner Image">
            <h2>Ăn ngon<br>Sống khỏe<br>Vui vẻ</h2>
        </div>

        <div class="product-sale">
            <?php foreach ($productsBestSellers as $productsBestSeller):?>
                <div class="product-card">
                    <span class="discount-tag <?=($outstandingProduct['discount'] > 0) ? '' : 'hidden'?>">-<?=$outstandingProduct['discount']?>%</span>
                    <div class="product-image-wrapper">
                        <img src="<?=$productsBestSeller['image']?>" alt="<?=$productsBestSeller['name']?>">
                    </div>
                    <h3><?=$productsBestSeller['name']?></h3>
                    <p><?=$productsBestSeller['description']?></p>
                    <p class="price">
                        <?php if (!empty($productsBestSeller['default_variant']['price_sale'])): ?>
                            <?= number_format((float)$productsBestSeller['default_variant']['price_sale'], 0, ',', '.') ?>đ
                        <?php else: ?>
                            <?= number_format((float)$productsBestSeller['default_variant']['price'], 0, ',', '.') ?>đ
                        <?php endif; ?>
                        <span class="original-price">
                        <?= !empty($productsBestSeller['default_variant']['price_sale']) && !empty($productsBestSeller['default_variant']['price']) ? number_format((float)$productsBestSeller['default_variant']['price'], 0, ',', '.') . 'đ' : '' ?>
                    </span>
                    </p>
                    <span>
                        <?=$productsBestSeller['total_sold']?> lượt bán
                    </span>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>
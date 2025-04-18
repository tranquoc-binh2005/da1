<section class="container ">
    <br>
    <h1 class="section-title">Sản phẩm nỗi bật</h1>

    <!-- Filter Bar -->
    <div class="">
        <button data-id="" class="filter-btn active filter-product-by-category">Tất cả</button>
        <?php foreach ($outstandingCategories as $outstandingCategorie):?>
            <button class="filter-btn filter-product-by-category" data-id="<?=$outstandingCategorie['id']?>"><?=$outstandingCategorie['name']?></button>
        <?php endforeach;?>
    </div>

    <!-- Product Grid -->
    <div class="product-grid">
        <?php foreach ($outstandingProducts as $outstandingProduct):?>
            <div class="product-card">
                <span class="discount-tag <?=($outstandingProduct['discount'] > 0) ? '' : 'hidden'?>">-<?=$outstandingProduct['discount']?>%</span>
                <div class="product-image-wrapper">
                    <img loading="lazy" src="<?=$outstandingProduct['image']?>" alt="<?=$outstandingProduct['name']?>">
                </div>
                <h3>
                    <a href="san-pham/chi-tiet-san-pham/<?=$outstandingProduct['canonical']?>"><?=$outstandingProduct['name']?></a>
                </h3>
                <p><?=$outstandingProduct['description']?></p>
                <p class="price">
                    <?php if (!empty($outstandingProduct['default_variant']['price_sale'])): ?>
                        <?= number_format((float)$outstandingProduct['default_variant']['price_sale'], 0, ',', '.') ?>đ
                    <?php else: ?>
                        <?= number_format((float)$outstandingProduct['default_variant']['price'], 0, ',', '.') ?>đ
                    <?php endif; ?>

                    <span class="original-price">
                        <?= !empty($outstandingProduct['default_variant']['price_sale']) && !empty($outstandingProduct['default_variant']['price']) ? number_format((float)$outstandingProduct['default_variant']['price'], 0, ',', '.') . 'đ' : '' ?>
                    </span>
                </p>
            </div>
        <?php endforeach;?>
    </div>
</section>
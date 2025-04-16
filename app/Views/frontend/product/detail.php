<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="container">
    <div class="product-container">
        <!-- Product Images Section -->
        <div class="product-images">
            <div class="image-grid">
                <img src="<?=isset($product) ? $product['image'] : ''?>" alt="<?=$product['name'] ?? "Hình ảnh sản phẩm"?>">
                <?php
                $album = json_decode((isset($product) ? $product['album'] : []), true);
                foreach ($album as $img) {?>
                    <img loading="lazy" src="<?=$img?>" alt="<?=$product['name'] ?? "Hình ảnh sản phẩm"?>">
                <?php }?>
            </div>
            <div class="main-image">
                <img id="main-product-image" src="<?=isset($product) ? $product['image'] : ''?>" alt="<?=$product['name'] ?? "Hình ảnh sản phẩm"?>">
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="product-details">
            <p class="brand">Thương hiệu: <?=$product['name_brand']?></p>
            <p class="origin">Xuất xứ: Việt Nam</p>
            <h1 class="product-title"><?=$product['name']?></h1>
            <div class="rating">
                <span>★★★★★</span> (645)
            </div>
            <p class="description">
                <?=$product['description']?>
            </p>
            <div class="size-options">
                <select id="unit" class="unitProduct">
                    <?php foreach ($product['variants'] as $variant) {?>
                        <option
                                value="<?=$variant['unit_value'] . $variant['unit_name']?>"
                                data-price="<?=$variant['price']?>"
                                data-stock="<?=$variant['stock']?>"
                                data-id="<?=$variant['id']?>"
                                data-price-sale="<?=$variant['price_sale']?>"
                            <?=($variant['unit_value'] === $product['default_variant']['unit_value']) ? 'selected' : ''?>
                        >
                            <?=$variant['unit']?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="price">
                <span class="current-price" id="current-price">
                    <?= !empty($product['default_variant']['price_sale']) ? number_format($product['default_variant']['price_sale'], 0, ',', '.') . 'đ' : number_format($product['default_variant']['price'], 0, ',', '.') . 'đ' ?>
                </span>
                <span class="original-price" id="original-price"><?= !empty($product['default_variant']['price_sale']) ? number_format($product['default_variant']['price'], 0, ',', '.') . 'đ' : '' ?></span>
            </div>
            <p class="status-stock-product">
                Trạng thái:
                <span class="origin">Còn hàng</span>
            </p>
            <div class="quantity">
                <button class="btn-apart-stock">-</button>
                <input class="input-number-product" type="number" min="1" max="10" value="1">
                <button class="btn-add-stock">+</button>
            </div>
            <button data-product="<?=$product['id']?>" class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>

    <!-- Product Description Section -->
    <div class="product-description">
        <?=$product['content']?>
    </div>

    <?php if (!empty($_SESSION['recentlyProduct'])): ?>
    <div class="main-title mt-20">
        <h1 class="section-title">Sản phẩm đã xem gần đây</h1>
    </div>
    <div class="related-product">
        <?php foreach ($_SESSION['recentlyProduct'] as $key => $item): ?>
            <?php if ($key !== $product['canonical']): ?>
                <div class="product-card">
                    <span class="discount-tag <?=($item['discount'] > 0) ? '' : 'hidden'?>">-<?=$item['discount']?>%</span>
                    <div class="product-image-wrapper">
                        <img src="<?=$item['image']?>" alt="<?=$item['name']?>">
                    </div>
                    <h3>
                        <a href="<?=$item['canonical']?>"><?=$item['name']?></a>
                    </h3>
                    <p><?=$item['description']?></p>
                    <p class="price">
                        <?php if (!empty($item['default_variant']['price_sale'])): ?>
                            <?= number_format((float)$item['default_variant']['price_sale'], 0, ',', '.') ?>đ
                        <?php else: ?>
                            <?= number_format((float)$item['default_variant']['price'], 0, ',', '.') ?>đ
                        <?php endif; ?>

                        <span class="original-price">
                        <?= !empty($item['default_variant']['price_sale']) && !empty($item['default_variant']['price']) ? number_format((float)$item['default_variant']['price'], 0, ',', '.') . 'đ' : '' ?>
                    </span>
                    </p>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif;?>
</div>
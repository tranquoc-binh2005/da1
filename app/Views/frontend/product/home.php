<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="main-title mt-20 container">
    <h1 class="section-title titleCategory">Danh mục sản phẩm</h1>
</div>
<div class="container">
    <div class="filter-bar">
        <div class="form-group">
            <select class="form-control filter-perpage-product">
                <option value="9">9 sản phẩm</option>
                <option value="15">15 sản phẩm</option>
                <option value="20">20 sản phẩm</option>
                <option value="25">25 sản phẩm</option>
                <option value="30">30 sản phẩm</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control filter-select-product">
                <option>Lọc sản phẩm theo</option>
                <option value="id,desc">Lọc sản phẩm từ mới - cũ</option>
                <option value="id,asc">Lọc sản phẩm từ cũ - mới</option>
            </select>
        </div>
        <label for="" class="form-group">
            <input type="text" class="form-control filter-search-product" value="" placeholder="Tìm kiếm...">
        </label>
        <label for="" class="form-group">
            <button class="reset-filter-product">Reset</button>
        </label>
    </div>
</div>
<div class="main-product container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-box">
            <h3>Danh mục</h3>
            <ul class="category-list">
                <li class="li-filter-product-by-category" data-id="" data-name="">Tất cả</li>
                <?php foreach ($categories as $category):?>
                    <li class="li-filter-product-by-category"
                        data-id="<?=$category['id']?>"
                        data-name="<?=$category['name']?>"
                    >
                        <?=$category['name']?>
                        <span class="count"><?=$category['countProducts']?></span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="sidebar-box">
            <h3>Sản phẩm bán chạy</h3>
            <?php foreach ($productsBestSellers as $productsBestSeller):?>
            <div class="best-seller">
                <div class="best-seller-img">
                    <img src="<?=$productsBestSeller['image']?>" alt="<?=$productsBestSeller['name']?>">
                </div>
                <div class="best-seller-content">
                    <a href=""><?=$productsBestSeller['name']?></a>
                    <p class="price">
                        <?php if (!empty($productsBestSeller['default_variant']['price_sale'])): ?>
                            <?= number_format($productsBestSeller['default_variant']['price_sale'], 0, ',', '.') ?> đ
                        <?php else: ?>
                            <?= number_format($productsBestSeller['default_variant']['price'], 0, ',', '.') ?> đ
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content-product">
        <?php foreach ($products['data'] as $product):?>
            <div class="product-card">
                <span class="discount-tag <?=($product['discount'] > 0) ? '' : 'hidden'?>">-<?=$product['discount']?>%</span>
                <div class="product-image-wrapper">
                    <img src="<?=$product['image']?>" alt="<?=$product['name']?>">
                </div>
                <h3>
                    <a href="san-pham/chi-tiet-san-pham/<?=$product['canonical']?>"><?=$product['name']?></a>
                </h3>
                <p><?=$product['description']?></p>
                <p class="price">
                    <?php if (!empty($product['default_variant']['price_sale'])): ?>
                        <?= number_format((float)$product['default_variant']['price_sale'], 0, ',', '.') ?>đ
                    <?php else: ?>
                        <?= number_format((float)$product['default_variant']['price'], 0, ',', '.') ?>đ
                    <?php endif; ?>

                    <span class="original-price">
                        <?= !empty($product['default_variant']['price_sale']) && !empty($product['default_variant']['price']) ? number_format((float)$product['default_variant']['price'], 0, ',', '.') . 'đ' : '' ?>
                    </span>
                </p>
            </div>
        <?php endforeach;?>
        <?php
        if(count($products['data'])){
            include 'paginate.php';
        }
        ?>
    </div>
</div>
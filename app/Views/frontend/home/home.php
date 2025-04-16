<!-- Banner Section with Slick JS -->
<section class="container banner">
    <div class="banner-slider">
        <div>
            <img src="/public/hatvang/assets/img/banner-1.jpg" alt="Nuts 1">
        </div>
        <div>
            <img src="/public/hatvang/assets/img/banner-2.jpg" alt="Nuts 2">
        </div>
    </div>
</section>
<section class="container ">
    <!-- San pham danh cho ban -->
    <h1 class="section-title">Sản phẩm dành cho bạn</h1>

    <!-- Product Carousel -->
    <div class="product-carousel">
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
        <div class="product-item">
            <div class="product-item-img">
                <img src="/public/hatvang/assets/img/dau-ha-lan.jpg" alt="Hạt Hướng Dương">
            </div>
            <p>Hạt Hướng Dương</p>
            <p>22 sản phẩm</p>
        </div>
    </div>
</section>

<section class="container ">
    <!--     Featured Categories-->
    <div class="featured-categories">
        <div class="category-item">
            <img src="/public/hatvang/assets/img/cate_banner-2.png" alt="Đậu nành dinh dưỡng organic">
            <h3>Đậu nành dinh dưỡng organicĐậu nành dinh dưỡng organic</h3>
            <button class="explore-btn btn btn-primary">Khám phá</button>
        </div>
        <div class="category-item">
            <img src="/public/hatvang/assets/img/cate_banner-2.png" alt="Rau củ sạch tươi ngon">
            <h3>Rau củ sạch tươi ngon</h3>
            <button class="explore-btn btn btn-primary">Khám phá</button>
        </div>
        <div class="category-item">
            <img src="/public/hatvang/assets/img/cate_banner-2.png" alt="Nông sản hưu cơ organic">
            <h3>Nông sản hưu cơ organic</h3>
            <button class="explore-btn btn btn-primary">Khám phá</button>
        </div>
    </div>
</section>

<section class="container ">
    <br>
    <h1 class="section-title">Sản phẩm noi bat</h1>

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

<div class="main_desc">
    <div class="container">
        <div class="desc_main" style="display: flex;;">
            <div class="desc_list">
                <div class="decs_list--img">
                    <img src="img/tai-che.png" alt="">
                </div>
                <div class="desc_list--titel">
                    <div class="tetel-name">Tái chế môi trường </div>
                    <div class="tetel-desc">Nhằm mục đích chung tay giải cứu trái đất </div>
                </div>
            </div>
            <div class="desc_list">
                <div class="decs_list--img">
                    <img src="img/organic.png" alt="">
                </div>
                <div class="desc_list--titel">
                    <div class="tetel-name">Tái chế môi trường </div>
                    <div class="tetel-desc">Nhằm mục đích chung tay giải cứu trái đất </div>
                </div>
            </div>
            <div class="desc_list">
                <div class="decs_list--img">
                    <img src="img/natural.png" alt="">
                </div>
                <div class="desc_list--titel">
                    <div class="tetel-name">Tái chế môi trường  </div>
                    <div class="tetel-desc">Nhằm mục đích chung tay giải cứu trái đất </div>
                </div>
            </div>
            <div class="desc_list" style="border-right:none ;">
                <div class="decs_list--img">
                    <img src="img/fammer.png" alt="">
                </div>
                <div class="desc_list--titel">
                    <div class="tetel-name">Tái chế môi trường </div>
                    <div class="tetel-desc">Nhằm mục đích chung tay giải cứu trái đất </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container  mt-20">
    <div class="main-title">
        <h1 class="section-title">Bài viết</h1>
    </div>

    <!-- Blog Post Grid -->
    <div class="blog-grid">
        <?php foreach ($outstandingPosts as $outstandingPost):?>
        <div class="blog-card">
            <img src="<?=$outstandingPost['image']?>" alt="<?=$outstandingPost['name']?>">
            <div class="blog-content">
                <h3>
                    <?=$outstandingPost['name']?>
                </h3>
                <p>
                    <?=$outstandingPost['description']?>
                </p>
                <button class="btn btn-primary">
                    <a href="bai-viet/<?=$outstandingPost['canonical']?>">Xem thêm</a>
                </button>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</section>
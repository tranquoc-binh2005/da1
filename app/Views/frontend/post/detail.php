<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<div class="blog-detail mt-20">
    <h2 class="blog-detail__title"><?=$post['name']?></h2>

    <div class="blog-detail__meta mt-10">
        <span class="blog-detail__meta-category"><?=$post['name_catalogues']?></span>
        <span class="blog-detail__meta-date"><?=formatDateTimeVN($post['created_at'])?></span>
        <span class="blog-detail__meta-likes">Tác giả : <?=$post['author']?></span>
    </div>

    <div class="blog-detail__description">
        <?=$post['description']?>
    </div>
    <div class="blog-detail__content">
        <?=$post['content']?>
    </div>
</div>
<div class="slider-container container">
    <div class="main-title mt-20 container">
        <h1 class="section-title titleCategory">Bài viết liên quan</h1>
    </div>
    <div class="article-slider">
        <?php foreach ($postRelated as $val):?>
            <div class="article">
                <img src="<?=$val['image']?>" alt="<?=$val['name']?>">
                <span class="category"><?=$val['postCatalogueName']?></span>
                <h3>
                    <a href="/bai-viet/<?=$val['canonical']?>"><?=$val['name']?></a>
                </h3>
                <p><?=$val['description']?></p>
            </div>
        <?php endforeach;?>
    </div>
</div>
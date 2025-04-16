<div class="nav_list container-full">
    <a href="Home.html" class="conect">Trang chủ</a>
    <p class="conect">></p>
    <a href="" class="conect" style="color: #6F768D;">San pham</a>
</div>
<section class="container">
    <div class="blog__header">
        <div class="main-title mt-20 container">
            <h1 class="section-title titleCategory">Bài viết</h1>
        </div>
    </div>
    <div class="blog__posts">
        <?php foreach ($posts as $post):?>
            <article class="post">
                <img src="<?=$post['image']?>" alt="<?=$post['name']?>" class="post__image">
                <span class="post__category"><?=$post['postCatalogueName']?></span>
                <h2 class="post__title">
                    <a href="/bai-viet/<?=$post['canonical']?>"><?=$post['name']?></a>
                </h2>
                <p class="post__excerpt"><?=$post['description']?></p>
                <div class="post__meta">
                    <span class="post__date"><?=formatDateTimeVN($post['created_at'])?></span>
                </div>
            </article>
        <?php endforeach;?>
    </div>
</section>
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
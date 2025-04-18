<div class="container">
    <div class="review-section">
        <div class="review-actions">
            <button class="btn-rate" onclick="showReviews()">Tất cả đánh giá</button>
            <button class="btn-comment" onclick="showCommentForm()">Bình luận</button>
        </div>
        <div class="comment-form" id="commentForm">
            <div class="rating-options">
                <label for="" id="text-rating">Đánh giá:</label>
                <div class="rating-stars">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5">★</label>

                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4">★</label>

                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3">★</label>

                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2">★</label>

                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1">★</label>
                </div>
            </div>
            <input type="text" class="comment-input" placeholder="Họ và tên"></input>
            <input type="text" class="comment-input" placeholder="Email"></input>
            <textarea rows="5" class="comment-input" placeholder="Bình luận"></textarea>
            <div class="submit-comment">
                <button data-product="<?=$product['id']?>" class="btn btn-primary btn-send-rating-product">Bình luận</button>
            </div>
        </div>
        <div class="review-list active" id="reviewList">
            <?php foreach ($product['rating'] as $index => $rating): ?>
                <div class="review-item <?= $index > 2 ? 'hidden-review' : '' ?>">
                    <h3 class="username">
                        <strong><?= $rating['customer_name'] ?></strong>
                    </h3>
                    <span class="rating"><?= str_repeat('★', $rating['rating']) ?> (<?= $rating['rating_text'] ?>)</span>
                    <p class="content">
                        <?= $rating['customer_content'] ?> <br>
                        <span class="time-rating"><?= formatDateTimeVN($rating['created_at']) ?></span>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($product['rating']) > 3): ?>
            <div class="text-center mt-2">
                <button id="showMoreReview" class="btn btn-primary">Xem thêm đánh giá</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const showMoreBtn = document.getElementById('showMoreReview');
    const commentForm = document.getElementById('commentForm');
    const reviewList = document.getElementById('reviewList');

    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function () {
            document.querySelectorAll('.hidden-review').forEach(item => {
                item.style.display = 'block';
            });
            showMoreBtn.style.display = 'none';
        });
    }

    function showCommentForm() {
        commentForm.classList.add('active');
        reviewList.classList.remove('active');
        if (showMoreBtn) showMoreBtn.style.display = 'none';
    }

    function showReviews() {
        commentForm.classList.remove('active');
        reviewList.classList.add('active');
    }
</script>



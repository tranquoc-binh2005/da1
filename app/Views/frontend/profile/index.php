<div class="container flex-center mt-20">
    <div class="profile-container">
        <!-- Profile Section -->
        <div class="profile-header">
            <img src=" <?= $_SESSION['user']['image'] ?? '' ?>" alt=" <?= $_SESSION['user']['name'] ?? 'Chưa cập nhật' ?>" class="avatar">
            <div class="profile-info">
                <h2 class="user-name">
                    <?= $_SESSION['user']['name'] ?? 'Chưa cập nhật' ?>
                </h2>
                <p class="user-email">
                    Email:  <?= $_SESSION['user']['email'] ?? 'Chưa cập nhật' ?>
                </p>
            </div>
        </div>

        <!-- Form Section -->
        <form class="profile-form">
            <div class="form-group">
                <label for="name">Họ tên</label>
                <input type="text" id="name" value="<?= $_SESSION['user']['name'] ?? 'Chưa cập nhật' ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="<?= $_SESSION['user']['email'] ?? 'Chưa cập nhật' ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" value="<?= $_SESSION['user']['phone'] ?? 'Chưa cập nhật' ?>" readonly>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" id="address" value="<?= $_SESSION['user']['address'] ?? 'Chưa cập nhật' ?>" placeholder="Địa chỉ" readonly>
            </div>
            <div class="form-group">
                <label for="birthday">Ngày sinh</label>
                <input type="date" id="birthday" value="<?= $_SESSION['user']['birthday'] ?? null ?>" readonly>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea readonly type="text" id="bio" placeholder="Địa chỉ" rows="5"><?= $_SESSION['user']['bio'] ?? 'Chưa cập nhật' ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-update-profile">Cập nhật thông tin</button>
                <button type="button" class="btn btn-primary btn-save-profile hidden">Lưu lại</button>
            </div>
        </form>
    </div>
</div>
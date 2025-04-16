<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $breadcrumb['title'] ?? 'Thông tin người dùng' ?></h4>
        <p class="text-muted font-13">Lưu ý: các trường <span class="text-danger">*</span> là bắt buộc</p>

        <?php
        if(isset($errors)){
            foreach ($errors as $error) {
                foreach ($error as $e) {
                    echo '<div class="text-danger">-' . $e . '</div>';
                }
            }
        }
        ?>
    </div>

    <form class="col-md-8" action="<?= isset($user) ? 'dashboard/users/update/' . $user['id'] : 'dashboard/users/store' ?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Họ tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" readonly name="name" placeholder="Nhập họ tên" value="<?= isset($user) ? $user['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" readonly name="email" placeholder="Nhập email" value="<?= isset($user) ? $user['email'] : (old('email') ?? '') ?>">
            </div>
        </div>
        <?php if (!isset($user)): ?>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" readonly name="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" readonly name="confirm_password" placeholder="Xác nhận mật khẩu">
                </div>
            </div>
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Địa chỉ</label>
                <input type="text" class="form-control" readonly name="address" value="<?= isset($user) ? $user['address'] : (old('address') ?? '') ?>">
            </div>
            <div class="form-group col-md-3">
                <label class="col-form-label">Số điện thoại</label>
                <input type="number" class="form-control" readonly name="phone" min="0" value="<?= isset($user) ? $user['phone'] : (old('phone') ?? '') ?>">
            </div>

            <div class="form-group col-md-3">
                <label class="col-form-label">Ngày sinh</label>
                <input type="date" class="form-control" readonly name="birthday" min="0" value="<?= isset($user) ? $user['birthday'] : (old('birthday') ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-form-label">Bio</label>
            <input type="text" name="bio" class="form-control" readonly placeholder="Đôi nét về bạn..." value="<?= isset($user) ? $user['bio'] : (old('bio') ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="col-form-label">Ảnh đại diện</label>
            <input type="file" name="image" class="form-control" readonly data-type="Images">
            <img src="<?= isset($user) ? $user['image'] : (old('image') ?? '') ?>" alt="<?= isset($user) ? $user['name'] : (old('name') ?? '') ?>">
        </div>

        <div class="form-group text-right mb-0">
<!--            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>-->
            <button type="submit" class="btn btn-info waves-effect waves-light">
                <a class="text-white" href="/dashboard/users/index">Quay về</a>
            </button>
        </div>
    </form>
</div>

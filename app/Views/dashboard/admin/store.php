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
    <form class="col-md-8" action="<?= isset($admin) ? 'dashboard/admins/update/' . $admin['id'] : 'dashboard/admins/store' ?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Họ tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên" value="<?= isset($admin) ? $admin['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" placeholder="Nhập email" value="<?= isset($admin) ? $admin['email'] : (old('email') ?? '') ?>">
            </div>
        </div>
        <?php if (!isset($admin)): ?>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Xác nhận mật khẩu">
                </div>
            </div>
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Địa chỉ</label>
                <input type="text" class="form-control" name="address" value="<?= isset($admin) ? $admin['address'] : (old('address') ?? '') ?>">
            </div>
            <div class="form-group col-md-3">
                <label class="col-form-label">Số điện thoại</label>
                <input type="number" class="form-control" name="phone" min="0" value="<?= isset($admin) ? $admin['phone'] : (old('phone') ?? '') ?>">
            </div>

            <div class="form-group col-md-3">
                <label class="col-form-label">Ngày sinh</label>
                <input type="date" class="form-control" name="birthday" min="0" value="<?= isset($admin) ? $admin['birthday'] : (old('birthday') ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-form-label">Bio</label>
            <input type="text" name="bio" class="form-control" placeholder="Đôi nét về bạn..." value="<?= isset($admin) ? $admin['bio'] : (old('bio') ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="col-form-label">Vai trò</label>
            <select name="role_id" class="form-control">
                <option value="">Sắp xếp theo vai trò</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id'] ?>"
                        <?= (isset($admin['role_id']) && in_array($role['id'], (array) $admin['role_id']))
                        || (old('role_id') && in_array($role['id'], (array) old('role_id'))) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($role['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="col-form-label">Ảnh đại diện</label>
            <input type="file" name="image" class="form-control" value="<?= isset($admin) ? $admin['image'] : (old('image') ?? '') ?>" data-type="Images">
            <div class="image-avatar">
                <img src="<?= isset($admin) ? $admin['image'] : (old('image') ?? '') ?>" alt="<?= isset($admin) ? $admin['name'] : (old('name') ?? '') ?>">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

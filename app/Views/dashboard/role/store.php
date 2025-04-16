<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $breadcrumb['title'] ?? 'Thông tin nhóm quản trị' ?></h4>
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

    <form class="col-md-8" action="<?= isset($role) ? 'dashboard/roles/update/' . $role['id'] : 'dashboard/roles/store' ?>" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Tên nhóm <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên" value="<?= isset($role) ? $role['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Canonical <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="canonical" placeholder="Nhập canonical" value="<?= isset($role) ? $role['canonical'] : (old('canonical') ?? '') ?>">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $breadcrumb['title'] ?? 'Thông tin nhóm quản trị' ?></h4>
        <p class="text-muted font-13">
            Lưu ý: các trường <span class="text-danger">*</span> là bắt buộc <br> <br>
            Quy ước giá trị: <br>
            module:index => 2^0 = 1 <br>
            module:create => 2^1 = 2 <br>
            module:store => 2^2 = 4 <br>
            module:show => 2^3 = 8 <br>
            module:update => 2^4 = 16 <br>
            module:delete => 2^4 = 32 <br>
            module:destroy => 2^4 = 64
        </p>

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

    <form class="col-md-8" action="<?= isset($permission) ? 'dashboard/permissions/update/' . $permission['id'] : 'dashboard/permissions/store' ?>" method="POST">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Tên quyền <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Ví dụ: permissions:index" value="<?= isset($permission) ? $permission['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Tên module <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="module" placeholder="Nhập tên module. Ví dụ permissions" value="<?= isset($permission) ? $permission['module'] : (old('module') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Giá trị<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="value" placeholder="Nhập giá trị. Ví dụ permissions:index = 1" value="<?= isset($permission) ? $permission['value'] : (old('value') ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Tiêu đề cho quyền</label>
                <input type="text" class="form-control" name="title" placeholder="Nhập họ tên" value="<?= isset($permission) ? $permission['title'] : (old('title') ?? '') ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Mô tả cho quyền</label>
                <input type="text" class="form-control" name="description" placeholder="Nhập tên module" value="<?= isset($permission) ? $permission['description'] : (old('description') ?? '') ?>">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

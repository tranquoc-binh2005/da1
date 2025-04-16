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

    <form class="col-md-8" action="<?= isset($unit) ? '/dashboard/unit_products/update/' . $unit['id'] : '/dashboard/unit_products/store' ?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Tên đơn vị<span class="text-danger">*</span></label>
                <input type="text" class="form-control"  name="name" placeholder="Ví dụ: gram, kilogram" value="<?= isset($unit) ? $unit['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Giá trị<span class="text-danger">*</span></label>
                <input type="number" class="form-control"  name="value" placeholder="Ví dụ: 250, 500" value="<?= isset($unit) ? $unit['value'] : (old('value') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Đơn vị<span class="text-danger">*</span></label>
                <input type="text" class="form-control"  name="unit" placeholder="Ví dụ: g, kg" value="<?= isset($unit) ? $unit['unit'] : (old('unit') ?? '') ?>">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

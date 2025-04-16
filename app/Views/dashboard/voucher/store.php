<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $breadcrumb['title'] ?? 'Thông tin voucher giảm giá' ?></h4>
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

    <form class="col-md-8" action="<?= isset($voucher) ? 'dashboard/vouchers/update/' . $voucher['id'] : 'dashboard/vouchers/store' ?>" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-form-label">Tên voucher<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên" value="<?= isset($voucher) ? $voucher['name'] : (old('name') ?? '') ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label">Mô tả</label>
                <input type="text" class="form-control" name="description" placeholder="Nhập canonical" value="<?= isset($voucher) ? $voucher['description'] : (old('description') ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Giá trị (%)<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="value" placeholder="Nhập giá trị" value="<?= isset($voucher) ? $voucher['value'] : (old('value') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Điều kiện tối thiểu</label>
                <input type="number" class="form-control" name="min" placeholder="Giảm giá cho đơn hàng từ..." value="<?= isset($voucher) ? $voucher['min'] : (old('min') ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Giới hạn giảm giá (vnđ)</label>
                <input type="number" class="form-control" name="max" placeholder="Số tiền giới hạn của giảm giá..." value="<?= isset($voucher) ? $voucher['max'] : (old('max') ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label class="col-form-label">Số lượng<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="quantity" placeholder="Số lượng..."
                       value="<?= isset($voucher) ? $voucher['quantity'] : (old('quantity') ?? '') ?>"">
            </div>
            <div class="form-group col-md-5">
                <label class="col-form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" name="start_at"
                       value="<?= isset($voucher) ? date('Y-m-d\TH:i', strtotime($voucher['start_at'])) : (old('start_at') ?? '') ?>">
            </div>
            <div class="form-group col-md-5">
                <label class="col-form-label">Ngày kết thúc</label>
                <input type="datetime-local" class="form-control" name="dead_at"
                       value="<?= isset($voucher) ? date('Y-m-d\TH:i', strtotime($voucher['dead_at'])) : (old('dead_at') ?? '') ?>">
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

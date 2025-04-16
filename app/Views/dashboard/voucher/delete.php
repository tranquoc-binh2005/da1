<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title">Xoá bản ghi</h4>
        <p class="text-muted font-13">
            Bạn có muốn xoá voucher giảm  <span class="text-danger"><?= $voucher['name']?></span> này không ?
        </p>
        <p class="text-danger font-13">
            Lưu ý: đây là hành động không thể hoàn tác
        </p>
    </div>

    <form action="/dashboard/vouchers/destroy/<?= $voucher['id'] ?? null ?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Tên voucher</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    readonly
                    value="<?=$voucher['name'] ?? ''?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Giá trị(%)</label>
                <input
                    type="text"
                    name="value"
                    class="form-control"
                    readonly
                    value="<?=$voucher['value'] ?? ''?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>

    </form>

</div>
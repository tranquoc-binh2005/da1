<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title">Xoá bản ghi</h4>
        <p class="text-muted font-13">
            Bạn có muốn xoá đơn vị <span class="text-danger"><?= $unit['name']?></span> có giá trị <span class="text-danger">(<?= $unit['value'] . $unit['unit']?>)</span> này không ?
        </p>
        <p class="text-danger font-13">
            Lưu ý: đây là hành động không thể hoàn tác
        </p>
    </div>

    <form action="/dashboard/unit_products/destroy/<?= $unit['id'] ?? null ?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Họ tên</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    readonly
                    value="<?=$unit['name'] ?? ''?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Email</label>
                <input
                    type="text"
                    name="email"
                    class="form-control"
                    readonly
                    value="<?=$unit['value'] ?? ''?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>

    </form>

</div>
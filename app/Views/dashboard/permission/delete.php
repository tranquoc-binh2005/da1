<div class="card-body row">
    <div class="col-md-6">
        <h4 class="header-title">Xoá bản ghi</h4>
        <p class="text-muted font-13">
            Bạn có muốn xoá quyền vai trò
            <span class="text-danger"><?= $permission['name']?></span>
            của module (<span class="text-danger"><?= $permission['name']?></span>) này không ?
        </p>
        <p class="text-danger font-13">
            Lưu ý: đây là hành động không thể hoàn tác
        </p>
    </div>

    <form action="/dashboard/permissions/destroy/<?= $permission['id'] ?? null ?>" method="POST" class="col-md-6">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Họ tên</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    readonly
                    value="<?=$permission['name'] ?? ''?>"
                >
            </div>
            <div class="form-group col-md-6">
                <label for="" class="col-form-label">Module</label>
                <input
                    type="text"
                    name="text"
                    class="form-control"
                    readonly
                    value="<?=$permission['module'] ?? ''?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>

    </form>

</div>
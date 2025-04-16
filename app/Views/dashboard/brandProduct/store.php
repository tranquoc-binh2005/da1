<div class="card-body row">
    <div class="col-md-4">
        <h4 class="header-title"><?= $title ?? 'Thông tin người dùng' ?></h4>
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

    <form class="col-md-8" action="<?= isset($brand) ? '/dashboard/brand_products/update/' . $brand['id'] : '/dashboard/brand_products/store' ?>" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="col-form-label">Tên thương hiệu<span class="text-danger">*</span></label>
                <input type="text" class="form-control"  name="name" placeholder="Ví dụ: Hạt Vàng Organic" value="<?= isset($brand) ? $brand['name'] : (old('name') ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="col-form-label">Mô tả thương hiệu</label>
                <textarea
                        type="text"
                        class="form-control"
                        name="description"
                        placeholder="Mô tả cho thương hiệu"
                ><?= isset($brand) ? $brand['description'] : old('description')?></textarea>
            </div>
        </div>

        <div class="form-row">
            <label for="" class="col-form-label">Hình ảnh thương hiệu</label> <br>
            <div class="form-group col-md-12 bg-light text-center">
                        <span class="image img-cover">
                            <img id="ckAvataImg" width="150px" class="image-target"
                                 src="<?= isset($brand['image']) && $brand['image'] ? $brand['image'] : (!empty(old('image')) ? old('image') : 'public/assets/images/no-image.jpg') ?>"
                                 alt="no images">
                        </span>
                <input
                        type="hidden"
                        id="ckAvata"
                        class="ck-target"
                        name="image"
                        value="<?=isset($brand['image']) && $brand['image'] ? $brand['image'] : (old('image') ?? '')?>"
                >
            </div>
        </div>

        <div class="form-group text-right mb-0">
            <button type="submit" class="btn btn-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>

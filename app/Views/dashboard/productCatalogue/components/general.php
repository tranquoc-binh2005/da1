<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Tên danh mục
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control"
                name="name"
                placeholder="Nhập tên danh mục bài viết..."
                value = "<?= isset($productCatalogue) ? $productCatalogue['name'] : old('name')?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Mô tả cho danh mục bài viết
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <textarea
                type="text"
                class="form-control"
                name="description"
                placeholder="Nhập mô tả cho danh mục bài viết..."
            ><?= isset($productCatalogue) ? $productCatalogue['description'] : old('description')?></textarea>
        </div>
    </div>
</div>

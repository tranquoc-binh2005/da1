<div class="col-md-12">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="" class="col-form-label">Tên sản phẩm
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control"
                name="name"
                placeholder="Nhập tên danh mục bài viết..."
                value = "<?= isset($product) ? $product['name'] : old('name')?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Mô tả sản phẩm
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <textarea
                type="text"
                class="form-control ck-editor"
                name="description"
                placeholder="Nhập mô tả sản phẩm..."
            ><?= isset($product) ? $product['description'] : old('description')?></textarea>
        </div>

        <div class="col-md-12">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="" class="col-form-label">Nội dung
                        <span id="charCount" class="count_meta-title">0 kí tự</span>
                    </label>
                    <textarea
                            type="text"
                            class="form-control ck-editor countVachar"
                            name="content"
                            id="content"
                            placeholder="Nội dung cho sản phẩm..."
                            data-height="500"
                    ><?=(isset($product)) ? $product['content'] : old('content')?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

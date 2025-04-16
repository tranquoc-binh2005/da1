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
                value = "<?= isset($post) ? $post['name'] : old('name')?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Mô tả cho danh mục bài viết
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <textarea
                type="text"
                class="form-control ck-editor"
                name="description"
                placeholder="Nhập mô tả cho danh mục bài viết..."
            ><?= isset($post) ? $post['description'] : old('description')?></textarea>
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
                            placeholder="Nội dung bài viết..."
                            data-height="500"
                    ><?=(isset($post)) ? $post['content'] : old('content')?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

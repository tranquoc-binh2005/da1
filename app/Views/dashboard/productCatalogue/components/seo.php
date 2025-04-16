<div class="ibox-content">
    <div class="seo-container">
        <div class="meta_title">
            <h3><?= isset($productCatalogue) ? $productCatalogue['meta_title'] : old('meta_title')?></h3>
        </div>
        <div class="canonical">
            <?=BASE_URL?><?=isset($productCatalogue) ? $productCatalogue['canonical'] : old('canonical')?><?=SUFFIX?>
        </div>
        <div class="meta_description">
            <?= isset($productCatalogue) ? $productCatalogue['meta_description'] : old('meta_description')?>
        </div>
    </div>
    <hr>
    <div class="seo-wrapper">
        <div class="col-md-12">
            <label for="" class="col-form-label">Tiêu đề SEO
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <input
                type="text"
                class="form-control"
                name="meta_title"
                placeholder="Nhập tiêu đề SEO..."
                value = "<?= isset($productCatalogue) ? $productCatalogue['meta_title'] : old('meta_title')?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Từ khoá SEO</label>
            <input
                type="text"
                class="form-control"
                name="meta_keyword"
                placeholder="Nhập từ khoá SEO..."
                value = "<?= isset($productCatalogue) ? $productCatalogue['meta_keyword'] : old('meta_keyword')?>"
            >
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Mô tả SEO
                <span class="count_meta-title">0 kí tự</span>
            </label>
            <textarea
                type="text"
                class="form-control"
                name="meta_description"
                placeholder="Mô tả SEO..."
            ><?= isset($productCatalogue) ? $productCatalogue['meta_description'] : old('meta_description')?></textarea>
        </div>

        <div class="col-md-12">
            <label for="" class="col-form-label">Đường dẫn
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                class="form-control input-wapper"
                name="canonical"
                value = "<?= isset($productCatalogue) ? $productCatalogue['canonical'] : old('canonical')?>"
            >
<!--            <span class="baseUrl">{{ config('app.url') }}</span>-->
        </div>
    </div>
</div>

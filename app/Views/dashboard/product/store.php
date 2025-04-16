<div class="box pt-2">
    <form method="POST" action="<?= isset($product) ? ('dashboard/products/update/' . $product['id']) : 'dashboard/products/store'?>">
        <div class="d-flex gap-10">
            <div class="col-md-10 border-right">
                <div class="ibox col-md-12">
                    <h5 class="title">Nội dung chính</h5>
                    <p class="text-muted font-13">Lưu ý: các trường <span class="text-danger">*</span> là bắt buộc</p>
                    <hr>
                    <?php
                    if(isset($errors)){
                        foreach ($errors as $error) {
                            foreach ($error as $e) {
                                echo '<div class="text-danger">-' . $e . '</div>';
                            }
                        }
                    }
                    ?>
                    <div class="ibox-content">
                        <?php include 'components/general.php';?>
                    </div>
                    <div class="ibox-content">
                        <div class="album-wrapper">
                            <div class="title">
                                <p>ALBUM ẢNH</p>
                                <p class="multipleUploadImage">Chọn ảnh</p>
                            </div>
                            <div class="contentmultipleUploadImage content">
                                <p>
                                    <img class="multipleUploadImage" id="ckAlbum"
                                         src="public/assets/images/noimage.png" alt="">
                                </p>
                                <p>Sử dụng nút chọn hình hoặc nhấn vào đây để chọn hình ảnh</p>
                            </div>
                            <div id="imageContainer" class="image-container">
                                <?php
                                $albumImages = (isset($product['album'])) ? (json_decode($product['album'], true)) : (old('album') ?? []);
                                if (is_array($albumImages) && count($albumImages) > 0) {
                                    foreach ($albumImages as $key => $value) {
                                        ?>
                                        <span class="image-wrapper">
                                            <img class="multipleUploadImage uploaded-image" src="<?=$value?>" alt="<?=$value?>">
                                            <input type="hidden" name="album[]" value="<?=$value?>">
                                            <span class="delete-icon">x</span>
                                        </span>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox col-md-12">
                    <h5 class="title">Biến thể của sản phẩm</h5>
                    <hr>
                    <?php include 'components/variant.php';?>
                </div>
                <div class="ibox col-md-12">
                    <h5 class="title">Giảm giá sản phẩm</h5>
                    <hr>
                    <?php include 'components/discount.php';?>
                </div>
                <div class="ibox col-md-12">
                    <h5 class="title">Nội dung SEO</h5>
                    <hr>
                    <?php include 'components/seo.php';?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Danh mục sản phẩm
                            <span class="text-danger">*</span> <br>
                        </label>
                        <select name="product_catalogue_id" class="form-control">
                            <option value="">[Chọn danh mục]</option>
                            <?php foreach ($productCatalogues as $val) { ?>
                                <option value="<?= $val['id'] ?>"
                                    <?= (isset($product['product_catalogue_id']) && $product['product_catalogue_id'] == $val['id'])
                                        ? 'selected'
                                        : ((old('product_catalogue_id') == $val['id']) ? 'selected' : '') ?>>
                                    <?= str_repeat('|--', $val['level'] - 1) . ' ' . $val['name']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Thương hiệu sản phẩm
                            <span class="text-danger">*</span> <br>
                        </label>
                        <select name="brand_product_id" class="form-control">
                            <option value="">[Chọn thương hiệu]</option>
                            <?php foreach ($brands as $brand) { ?>
                                <option value="<?= $brand['id'] ?>"
                                    <?= (isset($product['brand_product_id']) && $product['brand_product_id'] == $brand['id'])
                                        ? 'selected'
                                        : ((old('brand_product_id') == $brand['id']) ? 'selected' : '') ?>>
                                    <?=$brand['name']?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <label for="" class="col-form-label">Hinh anh</label> <br>
                    <div class="form-group col-md-12 bg-light text-center">
                        <span class="image img-cover">
                            <img id="ckAvataImg" width="150px" class="image-target"
                                 src="<?= isset($product['image']) && $product['image'] ? $product['image'] : (!empty(old('image')) ? old('image') : 'public/assets/images/noimage.png') ?>"
                                 alt="no images">
                        </span>
                        <input type="hidden" id="ckAvata" class="ck-target" name="image" value="<?=isset($product['image']) && $product['image'] ? $product['image'] : (old('image') ?? '')?>">
                    </div>
                </div>

                <div class="form-row">
                    <?php include 'components/aside.php';?>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right mb-0 mt-2">
            <button type="submit" class="btn btn-outline-danger waves-effect waves-light">Lưu lại</button>
        </div>
    </form>
</div>
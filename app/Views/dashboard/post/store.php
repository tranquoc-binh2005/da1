<div class="box pt-2">
    <form method="POST" action="<?= isset($post) ? ('dashboard/posts/update/' . $post['id']) : 'dashboard/posts/store'?>">
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
                        <label for="" class="col-form-label">Danh muc cha
                            <span class="text-danger">*</span> <br>
                        </label>
                        <select name="post_catalogue_id" class="form-control">
                            <option value="1">root</option>
                            <?php foreach ($postCatalogues as $val) { ?>
                                <option value="<?= $val['id'] ?>"
                                    <?= (isset($post['post_catalogue_id']) && $post['post_catalogue_id'] == $val['id'])
                                        ? 'selected'
                                        : ((old('post_catalogue_id') == $val['id']) ? 'selected' : '') ?>>
                                    <?= str_repeat('|--', $val['level'] - 1) . ' ' . $val['name']?>
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
                                 src="<?= isset($post['image']) && $post['image'] ? $post['image'] : (!empty(old('image')) ? old('image') : 'public/assets/images/no-image.jpg') ?>"
                                 alt="no images">
                        </span>
                        <input type="hidden" id="ckAvata" class="ck-target" name="image" value="<?=isset($post['image']) && $post['image'] ? $post['image'] : (old('image') ?? '')?>">
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
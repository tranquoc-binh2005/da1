<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Upvex</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Basic Tables</li>
                </ol>
            </div>
            <h4 class="page-title"><?=$title ?? ""?></h4>
        </div>
    </div>
</div>
<div class="card-box">
    <form action="" method="GET">
        <div class="filter-box">
            <a class="btn btn-info" href="/dashboard/products/create">Thêm mới</a>
            <div class="app-search-box bg-light mr-2">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm" value="<?= old('keyword')?>">
                    <div class="input-group-append">
                        <button class="btn" type="submit">
                            <i class="fe-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mr-2">
                <select name="publish" class="form-control">
                    <option value="">Chọn trạng thái</option>
                    <option value="1" <?=old('publish') == 1 ? 'selected' : ''?>>Xuất bản</option>
                    <option value="2" <?=old('publish') == 2 ? 'selected' : ''?>>Không xuất bản</option>
                </select>
            </div>

            <div class="mr-2">
                <select name="sort" class="form-control">
                    <?php $oldSort = urldecode(old('sort')) ?? "";?>
                    <option value="">Sắp xếp theo thứ tự</option>
                    <option value="id,asc" <?=$oldSort == 'id,asc' ? 'selected' : ''?>>Từ cũ đến mới</option>
                    <option value="id,desc" <?=$oldSort == 'id,desc' ? 'selected' : ''?>>Từ mới đến cũ</option>
                </select>
            </div>

            <div class="mr-2">
                <select name="product_catalogue_id" class="form-control">
                    <?php $oldRoleId = urldecode(old('product_catalogue_id')) ?? "";?>
                    <option value="">Sắp xếp theo vai trò</option>
                    <?php foreach ($productCatalogues as $productCatalogue) { ?>
                        <option value="<?= $productCatalogue['id'] ?>" <?= $oldRoleId == $productCatalogue['id'] ? 'selected' : '' ?>>
                            <?= str_repeat('|--', $productCatalogue['level'] - 1) . ' ' . $productCatalogue['name']?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="entries right-0 col-2">
                <select name="perpage" class="form-control">
                    <?php for ($i = 20; $i <= 100; $i+=20) {?>
                        <option value="<?=$i?>" <?=old('perpage') == $i ? 'selected' : ''?>><?=$i?> bản ghi</option>
                    <?php }?>
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th class="text-center">Thumbnail</th>
                <th width="500px">Tên sản phẩm</th>
                <th width="500px" class="text-left">Mô tả ngắn sản phẩm</th>
                <th width="80px" class="text-left">Lên TOP</th>
                <th width="120px" class="text-center">Xuất bản</th>
                <th width="100px" class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(empty($products['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>
            <?php foreach ($products['data'] as $product) {?>
            <tr>
                <td class="ol-info">
                    <img class="image" src="<?= $product['image']?>" alt="<?= $product['name']?>">
                </td>
                <td class="text-left" width="350px">
                    <strong class="text-primary"><?=$product['name']?></strong> <br>
                    Danh mục: <span class="text-success"><?=$product['category_name']?></span> <br>
                    Thương hiệu: <span class="text-danger"><?=$product['brand_name'] ?? "Chưa cập nhật"?></span> <br>
                    Người tạo: <span class="text-info"><?=$product['admin_name']?></span> <br>
                </td>
                <td>
                    <?= $product['description'] ?: 'Chưa cập nhật' ?>
                </td>
                <td class="ol-info">
                    <input type="number"
                           class="inputOrderTop"
                           name="order"
                           value="<?=$product['order']?>"
                           data-field="products"
                           data-id="<?=$product['id']?>"
                           data-column="`order`"
                    >
                </td>
                <th class="text-center">
                    <input type="checkbox"
                           <?=$product['publish'] === 1 ? 'checked' : ''?>
                           data-plugin="switchery"
                           data-color="#64b0f2"
                           data-size="small"
                           data-switchery="true"
                           style="display: none;"
                           class="changeStatusPublish"
                           data-field="products"
                           data-id="<?=$product['id']?>"
                           data-column="publish"
                           data-publish="<?=$product['publish']?>">
                </th>
                <th class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/products/show/<?=$product['id']?>" title="Chỉnh sửa sản phẩm">
                        <i class="fe-edit"></i>
                    </a>
                    <a style="font-size: 20px; color:rgb(241, 55, 55);" href="/dashboard/products/delete/<?=$product['id']?>" title="Xóa sản phẩm">
                        <i class="fe-trash"></i>
                    </a>
                    <br>
                    <a style="font-size: 20px; color:#23b397;"
                       id="btnShowModalProductVariant"
                       title="Biến thể sản phẩm"
                       data-product="<?=$product['id']?>"
                       data-name="<?=$product['name']?>"
                       data-toggle="modal"
                       data-target="#variantProduct"
                    >
                        <i class="fe-sliders"></i>
                    </a>
                </th>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(!empty($products['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>

    </div>
</div>

<?php include 'modal/variant.php';?>
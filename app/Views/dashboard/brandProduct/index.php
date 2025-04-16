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
            <a class="btn btn-info" href="/dashboard/brand_products/create">Thêm mới</a>
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
                    <option value="">Sắp xếp theo</option>
                    <option value="id,asc" <?=$oldSort == 'id,asc' ? 'selected' : ''?>>Từ cũ đến mới</option>
                    <option value="id,desc" <?=$oldSort == 'id,desc' ? 'selected' : ''?>>Từ mới đến cũ</option>
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
                <th>Tên đơn vị</th>
                <th class="text-left">Giá trị</th>
                <th width="100px" class="text-center">Xuất bản</th>
                <th width="100px" class="text-center">#</th>
            </tr>
            </thead>
            <tbody>

            <?php if(empty($brands['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>

            <?php foreach ($brands['data'] as $brand) {?>
            <tr>
                <td class="col-info text-left" width="350px">
                    <img class="avata" loading="lazy" width="100px" src="<?=$brand['image'] ?? "/public/assets\images\users\user-3.jpg"?>" alt="">
                    <p class="information">
                        Họ tên: <?=$brand['name']?> <br>
                        Người tạo: <?=$brand['admin_name']?> <br>
                    </p>
                </td>
                <td><?= $brand['description'] ?? 'Chưa cập nhật' ?></td>
                <th class="text-center">
                    <input type="checkbox"
                        <?=$brand['publish'] === 1 ? 'checked' : ''?>
                           data-plugin="switchery"
                           data-color="#64b0f2"
                           data-size="small"
                           data-switchery="true"
                           style="display: none;"
                           class="changeStatusPublish"
                           data-field="brand_products"
                           data-id="<?=$brand['id']?>"
                           data-column="publish"
                           data-publish="<?=$brand['publish']?>">
                </th>
                <th class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/brand_products/show/<?=$brand['id']?>"><i class="fe-edit"></i></a>
                    <a style="font-size: 20px; color:rgb(241, 55, 55);" href="/dashboard/brand_products/delete/<?=$brand['id']?>"><i class="fe-trash"></i></a>
                </th>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(!empty($brands['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>

    </div>
</div>

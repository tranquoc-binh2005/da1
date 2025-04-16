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
            <a class="btn btn-info" href="/dashboard/posts/create">Thêm mới</a>
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
                <select name="post_catalogue_id" class="form-control">
                    <?php $oldRoleId = urldecode(old('post_catalogue_id')) ?? "";?>
                    <option value="">Sắp xếp theo vai trò</option>
                    <?php foreach ($postCatalogues as $postCatalogue) { ?>
                        <option value="<?= $postCatalogue['id'] ?>" <?= $oldRoleId == $postCatalogue['id'] ? 'selected' : '' ?>>
                            <?= str_repeat('|--', $postCatalogue['level'] - 1) . ' ' . $postCatalogue['name']?>
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
                <th width="500px">Tên bài viết</th>
                <th width="500px" class="text-left">Mô tả bài viết</th>
                <th class="text-left">Thumbnail</th>
                <th width="100px" class="text-center">Xuất bản</th>
                <th width="100px" class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(empty($posts['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>
            <?php foreach ($posts['data'] as $post) {?>
            <tr>
                <td class="text-left" width="350px">
                    <?=$post['name']?> <br>
                    danh muc: <?=$post['postCatalogueName']?>
                </td>
                <td>
                    <?= $post['description'] ?: 'Chưa cập nhật' ?>
                </td>
                <td class="ol-info">
                    <img class="image" src="<?= $post['image']?>" alt="<?= $post['name']?>">
                </td>
                <th class="text-center">
                    <input type="checkbox"
                           <?=$post['publish'] === 1 ? 'checked' : ''?>
                           data-plugin="switchery"
                           data-color="#64b0f2"
                           data-size="small"
                           data-switchery="true"
                           style="display: none;"
                           class="changeStatusPublish"
                           data-field="posts"
                           data-id="<?=$post['id']?>"
                           data-column="publish"
                           data-publish="<?=$post['publish']?>">
                </th>
                <th class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/posts/show/<?=$post['id']?>"><i class="fe-edit"></i></a>
                    <a style="font-size: 20px; color:rgb(241, 55, 55);" href="/dashboard/posts/delete/<?=$post['id']?>"><i class="fe-trash"></i></a>
                </th>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(!empty($posts['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>

    </div>
</div>

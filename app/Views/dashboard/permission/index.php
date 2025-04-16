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
            <a class="btn btn-info" href="/dashboard/permissions/create">Thêm mới</a>
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
                <th>Tên</th>
                <th class="text-left">Người tạo</th>
                <th width="300px" class="text-center">Ngày tạo</th>
                <th width="300px" class="text-center">Cập nhật cuối cùng</th>
                <th width="150px" class="text-center">Trạng thái</th>
                <th class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(empty($permissions['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>
            <?php foreach ($permissions['data'] as $permission) {?>
            <tr>
                <td class="col-info text-left" width="350px">
                    Tên nhóm: <?=$permission['name']?> <br>
                    Tên module: <?=$permission['module']?> <br>
                    Giá trị: <?=$permission['value']?>
                </td>
                <td class="col-info text-left" width="350px">
                    Title: <?=$permission['title']?> <br>
                    Des: <?=$permission['description']?>
                </td>
                <th class="text-center">
                    <?=$permission['created_at']?>
                </th>

                <th class="text-center">
                    <?=$permission['updated_at']?>
                </th>
                <th class="text-center">
                    <input type="checkbox"
                        <?=$permission['publish'] === 1 ? 'checked' : ''?>
                           data-plugin="switchery"
                           data-color="#64b0f2"
                           data-size="small"
                           data-switchery="true"
                           style="display: none;"
                           class="changeStatusPublish"
                           data-field="permissions"
                           data-id="<?=$permission['id']?>"
                           data-column="publish"
                           data-publish="<?=$permission['publish']?>">
                </th>
                <th class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/permissions/show/<?=$permission['id']?>"><i class="fe-edit"></i></a>
                    <a style="font-size: 20px; color:rgb(241, 55, 55);" href="/dashboard/permissions/delete/<?=$permission['id']?>"><i class="fe-trash"></i></a>
                </th>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(isset($permissions['data']) && !empty($permissions['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>

    </div>
</div>

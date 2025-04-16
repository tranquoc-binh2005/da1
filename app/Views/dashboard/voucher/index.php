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
            <a class="btn btn-info" href="/dashboard/vouchers/create">Thêm mới</a>
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
                <th width="200px">Thông tin</th>
                <th width="500px" class="text-center">Thời gian</th>
                <th class="text-center">Ẩn / Hiện</th>
                <th class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(empty($vouchers['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>
            <?php foreach ($vouchers['data'] as $voucher) {?>
            <tr>
                <td class="col-info text-left" width="350px">
                    Giá trị voucher: <?=$voucher['value']?>(%)<br>
                    Số lượng voucher: <?=$voucher['quantity']?>(Lượt)<br>
                    Tên voucher: <?=$voucher['name']?> <br>
                    Mô tả: <?=$voucher['description']?> <br>
                    Bắt đầu từ: <?= number_format($voucher['min'], 0, '.', ',') ?> VND <br>
                    Giá trị giảm tối đa: <?= number_format($voucher['max'], 0, '.', ',') ?> VND <br>
                    Người tạo: <?=$voucher['admin_name']?>
                </td>
                <th class="text-center">
                    <span class="text-success">
                        <?=$start = (new DateTime($voucher['start_at']))->format('H:i:s d/m/Y');?>
                    </span>
                    -
                    <span class="text-danger">
                        <?=$end = (new DateTime($voucher['dead_at']))->format('H:i:s d/m/Y');?>
                    </span>
                </th>
                <th class="text-center">
                    <input type="checkbox"
                        <?=$voucher['publish'] === 1 ? 'checked' : ''?>
                           data-plugin="switchery"
                           data-color="#64b0f2"
                           data-size="small"
                           data-switchery="true"
                           style="display: none;"
                           class="changeStatusPublish"
                           data-field="vouchers"
                           data-id="<?=$voucher['id']?>"
                           data-column="publish"
                           data-publish="<?=$voucher['publish']?>">
                </th>
                <th class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/vouchers/show/<?=$voucher['id']?>"><i class="fe-edit"></i></a>
                    <a style="font-size: 20px; color:rgb(241, 55, 55);" href="/dashboard/vouchers/delete/<?=$voucher['id']?>"><i class="fe-trash"></i></a>
                </th>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(!empty($vouchers['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>
    </div>
</div>

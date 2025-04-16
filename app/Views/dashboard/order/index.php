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
            <button type="button" class="btn btn-info confirm-order <?= (old('status_order_id') >= 3 || ($_GET['status_order_id'] ?? 0) >= 3) ? 'hidden' : '' ?>">Xác nhận</button>
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
                <select name="status_order_id" class="form-control">
                    <?php $oldRoleId = urldecode(old('status_order_id')) ?? "";?>
                    <option value="">Sắp xếp theo trạng thái</option>
                    <?php foreach ($status as $val) { ?>
                        <option value="<?= $val['value'] ?>" <?= $oldRoleId == $val['value'] ? 'selected' : '' ?>>
                            <?=$val['name']?>
                        </option>
                    <?php } ?>
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
                <th>
                    <input type="checkbox" id="checkAll">
                </th>
                <th width="150px">Mã đơn hàng</th>
                <th width="500px" class="text-left">Thông tin đơn hàng</th>
                <th width="500px" class="text-left">Thông tin khách hàng</th>
                <th width="150px" class="text-center">Trạng thái</th>
                <th width="50px" class="text-center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php if(empty($orders['data'])){?>
                <tr>
                    <td class="text-center" colspan="5">Không có bản ghi phù hợp</td>
                </tr>
            <?php }?>
            <?php foreach ($orders['data'] as $order) {?>
            <tr>
                <td>
                    <input type="checkbox" data-status="<?=$order['status_order_id']?>" data-id="<?=$order['id']?>" class="checkbox">
                </td>
                <td class="col-info text-left" width="350px">
                    <?=$order['code']?><br>
                </td>
                <?php
                $paymentText = match ($order['payment_method']) {
                    'cod' => 'Thanh toán khi nhận hàng',
                    'paypal' => 'Thanh toán PayPal',
                    'momo' => 'Thanh toán MoMo',
                }
                ?>
                <td class="text-left">
                    Ghi chú: <?=$order['description']?><br>
                    Phương thức thanh toán: <?=$paymentText?><br>
                    Thành tiền: <?=formatCurrencyVN($order['total_price'])?><br>
                </td>
                <td class="text-left">
                    Khách hàng: <?=$order['address_shopping_name']?><br>
                    Địa chỉ giao hàng: <?=$order['address_shopping_address']?><br>
                    Số điện thoại: <?=formatPhoneToVN($order['address_shopping_phone'])?><br>
                </td>
                <?php
                $status = match ($order['status_order_id']) {
                    1 => '<span class="badge badge-light-primary">Chờ xác nhận</span>',
                    2 => '<span class="badge badge-light-warning">Đang xử lý</span>',
                    3 => '<span class="badge badge-light-success">Thành công</span>',
                    4 => '<span class="badge badge-light-danger">Đã huỷ</span>',
                }
                ?>
                <td class="text-center">
                    <?=$status?>
                </td>
                <td class="text-center">
                    <a style="font-size: 20px;" href="/dashboard/orders/show/<?=$order['id']?>">
                        <i class="fe-upload-cloud"></i>
                    </a>
                </td>
            </tr>
            <tr>
            </tr>
            <?php }?>
            </tbody>
        </table>

        <?php if(!empty($orders['data'])){?>
            <?php include 'paginate.php' ?>
        <?php }?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Upvex</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Dashboard 2</li>
                </ol>
            </div>
            <h4 class="page-title">Thống kê</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-2">Đơn hàng đang chờ xác nhận</h4>

            <div class="mt-1">
                <div class="float-left text-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#f05050"
                            data-bgcolor="#48525e" value="<?= $newOrdersWaiting ?>" data-skin="tron"
                            data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial; text-align: left;
                               color: rgb(240, 80, 80); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="mt-3 pt-1 mb-1"> <?= $newOrdersWaiting ?> </h2>
                    <p class="text-muted mb-0">Đơn hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Đơn hàng đang xử lý</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#675db7"
                            data-bgcolor="#48525e" value="<?= $newOrdersProcessing ?>" data-skin="tron"
                            data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                            style="width: 36px; height: 21px;
                               position: absolute; vertical-align: middle; margin-top: 21px; margin-left: -50px;
                               border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(103, 93, 183);
                               padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="mt-3 pt-1 mb-1"> <?= $newOrdersProcessing ?> </h2>
                    <p class="text-muted mb-0">Đơn hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Đơn hàng thành công</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#23b397"
                            data-bgcolor="#48525e" value="<?= $newOrdersSuccess ?>" data-skin="tron"
                            data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial; text-align: center;
                               color: rgb(35, 179, 151); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="mt-3 pt-1 mb-1"> <?= $newOrdersSuccess ?> </h2>
                    <p class="text-muted mb-0">Đơn hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Đơn hàng đã huỷ</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#ffbd4a"
                            data-bgcolor="#48525e" value="<?= $newOrdersFailed ?>" data-skin="tron"
                            data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial;
                               text-align: center; color: rgb(255, 189, 74); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="mt-3 pt-1 mb-1"> <?= $newOrdersFailed ?> </h2>
                    <p class="text-muted mb-0">Đơn hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-2">Khách hàng mới</h4>

            <div class="mt-1">
                <div class="float-left text-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#f05050"
                            data-bgcolor="#48525e" value="<?= $newCustomers ?>" data-skin="tron"
                            data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial; text-align: left;
                               color: rgb(240, 80, 80); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="mt-3 pt-1 mb-1"> <?= $newCustomers ?> </h2>
                    <p class="text-muted mb-0">Khách hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Danh thu trong tuần</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#675db7"
                            data-bgcolor="#48525e" value="<?= $totalPricesByWeek ?>" data-max="10000000"
                            data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15"
                            readonly="readonly"
                            style="width: 36px; height: 21px;
                               position: absolute; vertical-align: middle; margin-top: 21px; margin-left: -50px;
                               border: 0px; background: none; font: bold 12px Arial; text-align: center; color: rgb(103, 93, 183);
                               padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="mt-3 pt-1 mb-1"> <?= formatCurrencyVN($totalPricesByWeek) ?> </h4>
                    <p class="text-muted mb-0">
                        Tuần thứ:
                        <?= date('W') ?>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Doanh thu trong tháng</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#23b397"
                            data-bgcolor="#48525e" value="<?= $totalPricesByMonth ?>" data-max="1000000000"
                            data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15"
                            readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial; text-align: center;
                               color: rgb(35, 179, 151); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="mt-3 pt-1 mb-1"> <?= formatCurrencyVN($totalPricesByMonth) ?> </h4>
                    <p class="text-muted mb-0">
                        Tháng: <?= date('n') ?>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Doanh thu trong quý</h4>

            <div class="mt-1">
                <div class="float-left customize-plugin" dir="ltr">
                    <div style="display:inline;width:64px;height:64px;">
                        <canvas width="128" height="128" style="width: 64px; height: 64px;"></canvas>
                        <input data-plugin="knob" data-width="64" data-height="64" data-fgcolor="#ffbd4a"
                            data-bgcolor="#48525e" value="<?= $totalPricesByQuarter ?>" data-max="4000000000"
                            data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".15"
                            readonly="readonly"
                            style="width: 36px; height: 21px; position: absolute; vertical-align: middle;
                               margin-top: 21px; margin-left: -50px; border: 0px; background: none; font: bold 12px Arial;
                               text-align: center; color: rgb(255, 189, 74); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="mt-3 pt-1 mb-1"> <?= formatCurrencyVN($totalPricesByQuarter) ?> </h4>
                    <p class="text-muted mb-0">
                        Quý thứ:
                        <?php
                        $month = date('n');
                        echo ceil($month / 3);
                        ?>
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Danh sách 10 sản phẩm bán chạy</h4>
                <p class="text-muted font-13 mb-4">
                    Sản phẩm bán chạy nhất của cửa hàng được lấy bằng tổng số lượt bán thành công của sản phẩm
                </p>

                <div id="top-products-best-seller" class="">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="datatable-buttons"
                                class="table table-striped dt-responsive nowrap dataTable no-footer dtr-inline collapsed"
                                role="grid" aria-describedby="datatable-buttons_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Hình</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá bán</th>
                                        <th>Số lượt bán</th>
                                        <th>Xem</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php foreach ($productBestSellers as $key => $productBestSeller):?>
                                        <tr role="row" class="odd">
                                            <td><?=$key + 1?></td>
                                            <td class="col-info">
                                                <img class="product-img" loading="lazy" src="<?=$productBestSeller['image']?>" alt="<?=$productBestSeller['name']?>">
                                            </td>
                                            <td>
                                                Sản phẩm: <?=$productBestSeller['name']?> <br>
                                                Danh mục: <?=$productBestSeller['product_catalogue_name']?> <br>
                                                Thương hiệu: <?=$productBestSeller['product_brand_name']?> <br>
                                            </td>
                                            <td>
                                                <?php
                                                $variant = $productBestSeller['default_variant'];
                                                $price = !empty($variant['price_sale']) && $variant['price_sale'] != 0
                                                    ? $variant['price_sale']
                                                    : $variant['price'];
                                                echo formatCurrencyVN($price);
                                                ?>
                                            </td>
                                            <td><?=$productBestSeller['total_sold']?></td>
                                            <td>
                                                <a style="font-size: 20px;" href="/dashboard/products/show/<?=$productBestSeller['id']?>" title="Chỉnh sửa sản phẩm">
                                                    <i class="fe-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<h4 class="header-title mt-20">Hoá đơn điện tử</h4>

<div class="card-box mt-20">
    <!-- Logo & title -->
    <div class="clearfix">
        <div class="float-left">
            <h3>Hạt Vàng Organic</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mt-3">
                <p><b>Xin chào, <?=$order['address_shopping_name']?></b></p>
                <p class="text-muted">Cảm ơn bạn rất nhiều vì đã tiếp tục mua sản phẩm của chúng tôi. Công ty chúng tôi
                    cam kết cung cấp cho bạn những sản phẩm chất lượng cao cũng như dịch vụ khách hàng
                    tuyệt vời cho mọi giao dịch.</p>
            </div>

        </div><!-- end col -->
    </div>
    <!-- end row -->

    <div class="row mt-3">
        <div class="cold-md-10 d-flex">
            <div class="col-md-6">
                <?php
                $status = match ($order['status_order_id']) {
                    1 => '<span class="badge badge-light-primary">Chờ xác nhận</span>',
                    2 => '<span class="badge badge-light-warning">Đang xử lý</span>',
                    3 => '<span class="badge badge-light-success">Thành công</span>',
                    4 => '<span class="badge badge-light-danger">Đã huỷ</span>',
                }
                ?>
                <h6>Thông tin giao hàng</h6>
                <address>
                    Khách hàng: <?=$order['address_shopping_name']?><br>
                    Địa chỉ: <?=$order['address_shopping_address']?><br>
                    Số điện thoại: <?=formatPhoneToVN($order['address_shopping_phone'])?> <br>
                    Trạng thái: <?=$status?>
                </address>
            </div>

            <?php
            $paymentText = match ($order['payment_method']) {
                'cod' => 'Thanh toán khi nhận hàng',
                'paypal' => 'Thanh toán PayPal',
                'momo' => 'Thanh toán MoMo',
            }
            ?>

            <div class="col-md-6">
                <div class="">
                    <h6>Thông tin hoá đơn</h6>
                    <address>
                        Mã đơn hàng: <?=$order['code']?> <br>
                        Phương thức thanh toán: <?=$paymentText?> <br>
                        Tổng tiền: <?=formatCurrencyVN($order['total_price'])?>
                    </address>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table mt-4 table-centered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th style="width: 10%">Số lượng</th>
                            <th style="width: 10%">Đơn giá</th>
                            <th style="width: 10%" class="text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order['detail'] as $key => $item):?>
                        <tr>
                            <td><?=$key + 1?></td>
                            <td width="60%">
                                <b><?=$item['name']?></b> <br>
                                <?=$item['description']?>
                            </td>
                            <td><?=$item['quantity']?></td>
                            <td><?=formatCurrencyVN($item['price'])?></td>
                            <td class="text-right"><?=formatCurrencyVN($item['price'] * $item['quantity'])?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div> <!-- end table-responsive -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-sm-6">
            <div class="clearfix pt-5">
                <h6 class="text-muted">Notes:</h6>

                <small class="text-muted">
                    Tất cả các tài khoản phải được thanh toán trong vòng 7 ngày kể từ ngày nhận được
                    hóa đơn. Thanh toán bằng séc hoặc thẻ tín dụng hoặc thanh toán trực tiếp
                    trực tuyến. Nếu tài khoản không được thanh toán trong vòng 7 ngày, các chi tiết tín dụng
                    được cung cấp để xác nhận công việc đã thực hiện sẽ bị tính
                    mức phí đã thỏa thuận được ghi chú ở trên.
                </small>
            </div>
        </div> <!-- end col -->
        <div class="col-sm-6">
            <div class="float-right">
                <h3>Tổng tiền: <?=formatCurrencyVN($order['total_price'])?></h3>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="mt-4 mb-1">
        <div class="text-right d-print-none">
            <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i>In hoá đơn</a>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoá đơn điện tử | Hạt Vàng Oganic</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Main container */
        .invoice-container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            color: #333333;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        /* Header: Logo & Title */
        .invoice-container__header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .invoice-container__header__logo img {
            height: 24px;
        }

        .invoice-container__header__title h4 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }

        /* Greeting & Order Info */
        .invoice-container__info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-container__info__greeting p {
            margin-bottom: 10px;
        }

        .invoice-container__info__greeting__text {
            color: #666666;
            width: 50%;
        }
        .invoice-container__info__order{
            width: 40%;
        }
        .invoice-container__info__order p {
            margin-bottom: 5px;
        }

        .invoice-container__info__order span {
            float: right;
        }

        .invoice-container__info__order__status {
            background-color: #28a745;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .item-info{
            width: 70%;
        }
        .item-info p{
            width: 60% !important;
            margin-top: 5px;
            font-size: 14px;
        }

        /* Billing & Shipping Addresses */
        .invoice-container__addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-container__addresses__billing,
        .invoice-container__addresses__shipping {
            width: 48%;
        }

        .invoice-container__addresses h6 {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333333;
        }

        .invoice-container__addresses address {
            color: #666666;
            line-height: 1.6;
        }

        /* Table for Items */
        .invoice-container__items__table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .invoice-container__items__table th,
        .invoice-container__items__table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .invoice-container__items__table th {
            font-weight: bold;
            color: #333333;
            background-color: #f8f9fa;
        }

        .invoice-container__items__table__total {
            text-align: right;
        }

        .invoice-container__items__table tbody td {
            color: #666666;
        }

        .invoice-container__items__table tbody b {
            color: #333333;
        }

        /* Notes & Total */
        .invoice-container__summary {
            display: flex;
            justify-content: space-between;
        }

        .invoice-container__summary__notes {
            width: 50%;
        }

        .invoice-container__summary__notes__title {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666666;
        }

        .invoice-container__summary__notes__text {
            font-size: 12px;
            color: #666666;
            line-height: 1.6;
        }

        .invoice-container__summary__total {
            position: absolute;
            right: 180px;
            text-align: right;
        }

        .invoice-container__summary__total p {
            margin-bottom: 5px;
        }

        .invoice-container__summary__total span {
            float: right;
        }

        .invoice-container__summary__total h3 {
            margin-top: 10px;
            font-size: 24px;
            color: #333333;
        }

        /* Buttons */
        .invoice-container__actions {
            text-align: right;
            margin-top: 20px;
        }

        .invoice-container__actions__print,
        .invoice-container__actions__submit {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            text-decoration: none;
            display: inline-block;
        }

        .invoice-container__actions__print {
            background-color: #007bff;
            color: #ffffff;
        }

        .invoice-container__actions__submit {
            background-color: #17a2b8;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="invoice-container">
    <!-- Header: Logo & Title -->
    <div class="invoice-container__header">
        <div class="invoice-container__header__logo">
            <h2>Hạt Vàng Organic</h2>
        </div>
    </div>

    <!-- Greeting & Order Info -->
    <div class="invoice-container__info">
        <div class="invoice-container__info__greeting">
            <p>Xin chào: <b><?=$dataInvoice['address_shopping_name']?></b></p>
            <p class="invoice-container__info__greeting__text">
                Cảm ơn bạn rất nhiều vì đã tiếp tục mua sản phẩm của chúng tôi. Công ty chúng tôi
                cam kết cung cấp cho bạn những sản phẩm chất lượng cao cũng như dịch vụ khách hàng
                tuyệt vời cho mọi giao dịch.
            </p>
        </div>
    </div>

    <!-- Billing & Shipping Address -->
    <div class="invoice-container__addresses">
        <div class="invoice-container__addresses__billing">
            <h6>Thông tin giao hàng</h6>
            <address>
                <?=$dataInvoice['address_shopping_name']?><br>
                <?=$dataInvoice['address_shopping_address']?><br>
                <?=formatPhoneToVN($dataInvoice['address_shopping_phone'])?><br>
            </address>
        </div>
        <?php
        $paymentText = match ($dataInvoice['payment_method']) {
            'cod' => 'Thanh toán khi nhận hàng',
            'paypal' => 'Thanh toán paypal',
            'momo' => 'Thanh toán MoMo',
        }
        ?>
        <div class="invoice-container__addresses__billing">
            <h6>Thông tin đơn hàng</h6>
            <address>
                <strong>Thời gian:</strong> <span><?=formatDateTimeVN($dataInvoice['created_at'])?></span><br>
                <strong>Phương thức thanh toán:</strong><?=$paymentText?><br>
                <strong>Mã đơn hàng:</strong> <span><?=$dataInvoice['code']?></span><br>
            </address>
        </div>
    </div>

    <!-- Table for Items -->
    <div class="invoice-container__items">
        <table class="invoice-container__items__table">
            <thead>
            <tr>
                <th>#</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th class="invoice-container__items__table__total">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataInvoice['detail'] as $key => $item): ?>
            <tr>
                <td><?=$key + 1?></td>
                <td class="item-info">
                    <b><?=$item['name']?></b><br>
                    <p class="description"><?=$item['description']?></p>
                </td>
                <td><?=$item['quantity']?></td>
                <td><?=formatCurrencyVN($item['price'])?></td>
                <td class="invoice-container__items__table__total"><?=formatCurrencyVN($item['price'] * $item['quantity'])?></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

    <!-- Notes & Total -->
    <div class="invoice-container__summary">
        <div class="invoice-container__summary__notes">
            <h6 class="invoice-container__summary__notes__title">Notes:</h6>
            <small class="invoice-container__summary__notes__text">
                Tất cả các tài khoản phải được thanh toán trong vòng 7 ngày kể từ ngày nhận được hóa đơn. Thanh toán bằng séc hoặc thẻ tín dụng hoặc thanh toán trực tuyến. Nếu tài khoản không được thanh toán trong vòng 7 ngày, các chi tiết tín dụng được cung cấp để xác nhận công việc đã thực hiện sẽ bị tính phí đã thỏa thuận được ghi chú ở trên.
            </small>
        </div>
        <div class="invoice-container__summary__total">
            <h3>Tổng: <?=formatCurrencyVN($dataInvoice['total_price'])?></h3>
        </div>
    </div>
</div>
</body>
</html>
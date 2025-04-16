<?php
namespace App\Http\Services\Impl\Payment;

use App\Enums\env;
class PaymentMethodService
{
    // Cấu hình cho Momo
    private $momoConfig = [
        'partnerCode' => 'YOUR_MOMO_PARTNER_CODE',
        'accessKey' => 'YOUR_MOMO_ACCESS_KEY',
        'secretKey' => 'YOUR_MOMO_SECRET_KEY',
        'momoUrl' => 'https://test-api.momo.vn/gw_payment/transactionProcess',
    ];

    // Xử lý thanh toán Momo
    public function processMomo($order)
    {
        $momoUrl = $this->momoConfig['momoUrl'];
        $partnerCode = $this->momoConfig['partnerCode'];
        $accessKey = $this->momoConfig['accessKey'];
        $secretKey = $this->momoConfig['secretKey'];

        // Thông tin đơn hàng
        $orderId = $order['orderId'];
        $amount = $order['amount'];
        $orderInfo = $order['info'];

        // Tạo mã yêu cầu
        $requestId = time();
        $requestData = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'returnUrl' => 'YOUR_RETURN_URL',
            'notifyUrl' => 'YOUR_NOTIFY_URL',
        ];

        // Tạo chữ ký yêu cầu
        $signature = $this->generateMomoSignature($requestData, $secretKey);
        $requestData['signature'] = $signature;

        // Gửi request tới Momo API
        $response = $this->sendPostRequest($momoUrl, $requestData);

        return json_decode($response, true);
    }

    // Hàm tạo chữ ký cho Momo
    private function generateMomoSignature($data, $secretKey)
    {
        ksort($data);
        $queryString = urldecode(http_build_query($data));
        return hash_hmac('sha256', $queryString, $secretKey);
    }

    // Gửi request POST tới Momo API
    private function sendPostRequest($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
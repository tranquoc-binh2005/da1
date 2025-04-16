<?php
namespace App\Http\Services\Impl\Payment;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Omnipay;
use App\Traits\Loggable;

class PaypalService {

    use Loggable;
    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setUsername("sb-dfdf039972198_api1.business.example.com");
        $this->gateway->setPassword("AEUQA7BJGVEPTFDG");
        $this->gateway->setSignature("AKCaSOlWBblU-4Gp7b8aMRxz.4kXAz1wmJuWp7PnMwreiU-gS4bmqo7t");
        $this->gateway->setTestMode(true);  // Chế độ sandbox
    }

    /**
     * @throws InvalidRequestException
     */
    public function createPayment($total, $currency, $returnUrl, $cancelUrl) {
        try {
            $response = $this->gateway->purchase([
                'amount' => $total,
                'currency' => $currency,
                'returnUrl' => $returnUrl,
                'cancelUrl' => $cancelUrl
            ])->send();

            if ($response->isRedirect()) {
                return $response;
            } else {
                echo "Error: " . $response->getMessage();
                exit;
            }
        } catch (\Omnipay\Common\Exception\InvalidRequestException $e) {
            throw $e;
        }
    }
    public function completePayment($token, $PayerID, $amount, $currency) {
        try {
            $response = $this->gateway->completePurchase([
                'token' => $token,
                'PayerID' => $PayerID,
                'amount' => $amount ?? $_SESSION['amount']['paypal'],
                'currency' => $currency
            ])->send();

            if ($response->isSuccessful()) {
                return true;
            } else {
                return false;
            }
        } catch (\Omnipay\Common\Exception\InvalidRequestException $e) {
            throw $e;
        }
    }

}

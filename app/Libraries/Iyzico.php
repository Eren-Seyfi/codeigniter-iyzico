<?php
namespace App\Libraries;

use App\Models\IyzicoModel;
use Exception;

class Iyzico
{
    protected $options;
    protected $request;
    protected $basketItems;

    public function __construct()
    {
        $iyzicoData = (new IyzicoModel())->getConfig();
        $this->request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $this->basketItems = [];

        if ($iyzicoData) {
            $this->options = new \Iyzipay\Options();
            $this->options->setApiKey($iyzicoData['api_key']);
            $this->options->setSecretKey($iyzicoData['secret_key']);

            // Duruma göre base_url_test veya base_url_production belirle
            $baseUrl = ($iyzicoData['status'] === 'test') ? $iyzicoData['base_url_test'] : $iyzicoData['base_url_production'];
            $this->options->setBaseUrl($baseUrl);
        } else {
            throw new Exception("Iyzico configuration not found in database. Please check your configuration.");
        }
    }

    public function setForm(array $params)
    {
        if (!isset($params['conversation_id'], $params['price'], $params['paid_price'], $params['basket_id'])) {
            throw new Exception("Form parameters are missing or incomplete.");
        }

        $iyzicoData = (new IyzicoModel())->getConfig();

        $this->request->setLocale(\Iyzipay\Model\Locale::TR);
        $this->request->setConversationId($params['conversation_id']);
        $this->request->setPrice($params['price']);
        $this->request->setPaidPrice($params['paid_price']);
        $this->request->setCurrency(\Iyzipay\Model\Currency::TL);
        $this->request->setBasketId($params['basket_id']);
        $this->request->setCallbackUrl($iyzicoData['callback_url']);
        $this->request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        return $this;
    }

    public function setBuyer(array $params)
    {
        if (!isset($params['id'], $params['name'], $params['surname'], $params['phone'], $params['email'], $params['identity'], $params['address'], $params['ip'], $params['city'], $params['country'])) {
            throw new Exception("Buyer parameters are missing or incomplete.");
        }

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($params['id']);
        $buyer->setName($params['name']);
        $buyer->setSurname($params['surname']);
        $buyer->setGsmNumber($params['phone']);
        $buyer->setEmail($params['email']);
        $buyer->setIdentityNumber($params['identity']);
        $buyer->setRegistrationAddress($params['address']);
        $buyer->setIp($params['ip']);
        $buyer->setCity($params['city']);
        $buyer->setCountry($params['country']);
        $this->request->setBuyer($buyer);

        return $this;
    }

    public function setShippingAddress(array $params)
    {
        if (!isset($params['name'], $params['city'], $params['country'], $params['address'])) {
            throw new Exception("Shipping address parameters are missing or incomplete.");
        }

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($params['name']);
        $shippingAddress->setCity($params['city']);
        $shippingAddress->setCountry($params['country']);
        $shippingAddress->setAddress($params['address']);
        $this->request->setShippingAddress($shippingAddress);

        return $this;
    }

    public function setBillingAddress(array $params)
    {
        if (!isset($params['name'], $params['city'], $params['country'], $params['address'])) {
            throw new Exception("Billing address parameters are missing or incomplete.");
        }

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($params['name']);
        $billingAddress->setCity($params['city']);
        $billingAddress->setCountry($params['country']);
        $billingAddress->setAddress($params['address']);
        $this->request->setBillingAddress($billingAddress);

        return $this;
    }

    public function setBasketItem(array $items)
    {
        if (empty($items)) {
            throw new Exception("Basket items cannot be empty.");
        }

        foreach ($items as $value) {
            if ($value['price'] <= 0) {
                throw new Exception("Basket item price must be greater than zero.");
            }

            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId($value['id']);
            $basketItem->setName($value['name']);
            $basketItem->setCategory1($value['category']);
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $basketItem->setPrice($value['price']);
            array_push($this->basketItems, $basketItem);
        }
        $this->request->setBasketItems($this->basketItems);

        return $this;
    }

    public function paymentForm()
    {
        $form = \Iyzipay\Model\CheckoutFormInitialize::create($this->request, $this->options);
        return $form;
    }

    public function verifyPayment($token)
    {
        if (empty($token)) {
            throw new \Exception("Payment token is required for verification.");
        }

        // Ödeme doğrulama isteği oluşturma
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR); // Tercihen TR veya EN
        $request->setToken($token);

        // İstek sonuçlarını al
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $this->options);

        // İstek sonucu başarılıysa
        if ($checkoutForm->getStatus() == "success") {
            return [
                'status' => true,
                'message' => $checkoutForm->getErrorMessage(),
                'paymentStatus' => $checkoutForm->getPaymentStatus(), // Ödeme durumu
                'token' => $checkoutForm->getToken(), // Token
                'paymentId' => $checkoutForm->getPaymentId(), // Ödeme ID'si
                'currency' => $checkoutForm->getCurrency(), // Para birimi
                'price' => $checkoutForm->getPrice(), // Ödenecek tutar
                'paidPrice' => $checkoutForm->getPaidPrice(), // Ödenen tutar
                'rawData' => $checkoutForm->getRawResult() // Ham veri
            ];
        } else {
            // Başarısız istek sonucu
            return [
                'status' => false,
                'message' => $checkoutForm->getErrorMessage(),
                'rawData' => $checkoutForm->getRawResult()
            ];
        }
    }

}

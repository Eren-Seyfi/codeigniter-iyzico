<?php
namespace App\Controllers;

use App\Libraries\Iyzico;

class Home extends BaseController
{
    public function index()
    {
        // Render the home view
        return view('home');
    }
    public function iyzicoResponsive()
    {
        $iyzico = new Iyzico();

        $formParams = [
            'conversation_id' => '123456789',
            'price' => '100.00',
            'paid_price' => '100.00',
            'basket_id' => 'B12345',
        ];

        $buyerParams = [
            'id' => 'BY789',
            'name' => 'Eren',
            'surname' => 'Seyfi',
            'phone' => '+905551234567',
            'email' => 'eren@example.com',
            'identity' => '11111111111',
            'address' => 'İstanbul, Türkiye',
            'ip' => $this->request->getIPAddress(),
            'city' => 'İstanbul',
            'country' => 'Turkey',
        ];

        $shippingAddressParams = [
            'name' => 'Eren Seyfi',
            'city' => 'İstanbul',
            'country' => 'Turkey',
            'address' => 'Kadıköy, İstanbul',
        ];

        $billingAddressParams = [
            'name' => 'Eren Seyfi',
            'city' => 'İstanbul',
            'country' => 'Turkey',
            'address' => 'Kadıköy, İstanbul',
        ];

        $basketItems = [
            [
                'id' => 'BI101',
                'name' => 'Telefon',
                'category' => 'Elektronik',
                'price' => '50.00',
            ],
            [
                'id' => 'BI102',
                'name' => 'Kulaklık',
                'category' => 'Elektronik',
                'price' => '50.00',
            ],
        ];

        // İyzico ödeme formunu oluştur
        $payment = $iyzico->setForm($formParams)
            ->setBuyer($buyerParams)
            ->setShippingAddress($shippingAddressParams)
            ->setBillingAddress($billingAddressParams)
            ->setBasketItem($basketItems)
            ->paymentForm();

        // Ödeme formunu view'e gönder
        return view('iyzico/responsive', [
            'paymentContent' => $payment->getCheckoutFormContent(),
            'status' => $payment->getStatus(),
            'iyzicoerror' => $payment->getErrorMessage(),
        ]);
    }
    public function iyzicoPopup()
    {
        $iyzico = new Iyzico();

        $formParams = [
            'conversation_id' => '123456789',
            'price' => '100.00',
            'paid_price' => '100.00',
            'basket_id' => 'B12345',
        ];

        $buyerParams = [
            'id' => 'BY789',
            'name' => 'Eren',
            'surname' => 'Seyfi',
            'phone' => '+905551234567',
            'email' => 'eren@example.com',
            'identity' => '11111111111',
            'address' => 'İstanbul, Türkiye',
            'ip' => $this->request->getIPAddress(),
            'city' => 'İstanbul',
            'country' => 'Turkey',
        ];

        $shippingAddressParams = [
            'name' => 'Eren Seyfi',
            'city' => 'İstanbul',
            'country' => 'Turkey',
            'address' => 'Kadıköy, İstanbul',
        ];

        $billingAddressParams = [
            'name' => 'Eren Seyfi',
            'city' => 'İstanbul',
            'country' => 'Turkey',
            'address' => 'Kadıköy, İstanbul',
        ];

        $basketItems = [
            [
                'id' => 'BI101',
                'name' => 'Telefon',
                'category' => 'Elektronik',
                'price' => '50.00',
            ],
            [
                'id' => 'BI102',
                'name' => 'Kulaklık',
                'category' => 'Elektronik',
                'price' => '50.00',
            ],
        ];

        // İyzico ödeme formunu oluştur
        $payment = $iyzico->setForm($formParams)
            ->setBuyer($buyerParams)
            ->setShippingAddress($shippingAddressParams)
            ->setBillingAddress($billingAddressParams)
            ->setBasketItem($basketItems)
            ->paymentForm();

        // Ödeme formunu view'e gönder
        return view('iyzico/popup', [
            'paymentContent' => $payment->getCheckoutFormContent(),
            'status' => $payment->getStatus(),
            'iyzicoerror' => $payment->getErrorMessage(),
        ]);
    }
    public function iyzicoPaymentVerify()
    {
        try {
            // İyzico kütüphanesini başlat
            $iyzico = new Iyzico();

            // İyzico'dan gelen token'ı al
            $token = $this->request->getPost('token');

            if (!$token) {
                throw new \Exception("Token not found.");
            }

            // Ödeme doğrulamasını yap
            $verificationResult = $iyzico->verifyPayment($token);

            // Eğer ödeme başarılıysa
            if ($verificationResult['status']) {
                return view('iyzico/verify_success', [
                    'message' => 'Ödeme başarılı!',
                    'paymentStatus' => $verificationResult['paymentStatus'],
                    'rawData' => $verificationResult['rawData']
                ]);
            } else {
                // Ödeme başarısızsa
                return view('iyzico/verify_fail', [
                    'message' => 'Ödeme başarısız: ' . $verificationResult['message'],
                    'rawData' => $verificationResult['rawData']
                ]);
            }
        } catch (\Exception $e) {
            // Hata durumunda kullanıcıya hata mesajı göster
            return view('iyzico/verify_fail', [
                'message' => 'Hata: ' . $e->getMessage()
            ]);
        }
    }

}

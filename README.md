
# İyzico Ödeme Sistemi Entegrasyonu / Iyzico Payment System Integration

Bu proje, İyzico ödeme sistemini CodeIgniter 4 ile entegre ederek, kullanıcıların ödeme yapmasına ve ödeme doğrulama işlemlerinin yapılmasına olanak sağlar. Projede iki farklı ödeme seçeneği mevcuttur: popup ve responsive ödeme formları. Ayrıca ödeme doğrulama işlemleri de gerçekleştirilir.

This project integrates the Iyzico payment system with CodeIgniter 4, allowing users to make payments and perform payment verification processes. The project provides two different payment options: popup and responsive payment forms. Payment verification is also performed.

## Gereksinimler / Requirements

- PHP 8.1 ve üzeri / PHP 8.1 or above
- CodeIgniter 4.5.5
- Composer
- İyzico PHP SDK / Iyzico PHP SDK

## Kurulum / Setup

### 1. Bu projeyi klonlayın: / Clone this project:
```bash
git clone https://github.com/Eren-Seyfi/codeigniter-iyzico.git
```

### 2. Gerekli bağımlılıkları yükleyin: / Install the required dependencies:
```bash
composer install
```

### 3. İyzico PHP SDK'yı yükleyin: / Install the Iyzico PHP SDK:
```bash
composer require iyzico/iyzipay-php
```

### 4. .env dosyasını yapılandırın: / Configure the .env file:
```bash
database.default.hostname = localhost
database.default.database = iyzico_db
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
app.baseURL = 'http://localhost:8080'
```

### 5. Veritabanı Migrations ve Seeds çalıştırın: / Run the database migrations and seeds:
```bash
php spark migrate
php spark db:seed IyzicoSeeder
```

### 6. İyzico API Anahtarlarını Yapılandırın: / Configure Iyzico API Keys:
Veritabanına, `IyzicoSeeder` ile eklenen test API anahtarlarını kullanabilirsiniz. Gerçek API anahtarlarını kullanmak için, `iyzico` tablosundaki `api_key` ve `secret_key` alanlarını güncelleyebilirsiniz.

You can use the test API keys added via `IyzicoSeeder` in the database. To use real API keys, update the `api_key` and `secret_key` fields in the `iyzico` table.

### 7. Projeyi Başlatın: / Start the project:
```bash
php spark serve
```

## Kullanım / Usage

### Adım 1: Ödeme Formu Gösterimi / Step 1: Display Payment Form
Aşağıdaki URL'lere giderek farklı ödeme formu seçeneklerini görüntüleyebilirsiniz:

Visit the following URLs to view different payment form options:

- Responsive Ödeme Formu: [http://localhost:8080/iyzico-responsive](http://localhost:8080/iyzico-responsive)
- Popup Ödeme Formu: [http://localhost:8080/iyzico-popup](http://localhost:8080/iyzico-popup)

### Adım 2: Ödeme Doğrulama / Step 2: Payment Verification
Ödeme tamamlandıktan sonra İyzico, belirlediğiniz `callback_url` üzerinden bir token gönderir. Bu token'ı kullanarak aşağıdaki URL ile ödeme doğrulamasını yapabilirsiniz:

After the payment is completed, Iyzico sends a token via the specified `callback_url`. You can verify the payment using this token at the following URL:

```bash
http://localhost:8080/iyzico-payment-verify
```

## Ödeme Doğrulama / Payment Verification
Ödeme doğrulama işlemi, `iyzicoPaymentVerify` fonksiyonu ile gerçekleştirilir. Bu fonksiyon, İyzico'dan gelen token'ı alır ve `verifyPayment` metodunu çağırarak ödeme durumunu sorgular. Eğer ödeme başarılıysa, başarılı bir mesaj, başarısızsa hata mesajı görüntülenir.

Payment verification is handled by the `iyzicoPaymentVerify` function. It takes the token received from Iyzico and calls the `verifyPayment` method to check the payment status. If the payment is successful, a success message is displayed; if not, an error message is shown.

### Ödeme Durumunu Sorgulama / Checking Payment Status
- **Başarılı Ödeme**: Ödeme başarılı olduğunda ekranda "Ödeme başarılı" mesajı gösterilir.
- **Başarısız Ödeme**: Ödeme başarısız olduğunda "Ödeme başarısız" mesajı gösterilir.

- **Successful Payment**: When the payment is successful, the message "Payment successful" is shown on the screen.
- **Failed Payment**: When the payment fails, the message "Payment failed" is displayed.

## Proje Yapısı / Project Structure

- **app/Controllers/Home.php**: Ödeme işlemlerini başlatan ve doğrulayan ana denetleyici.
- **app/Libraries/Iyzico.php**: İyzico ödeme ve doğrulama işlemlerini gerçekleştiren sınıf.
- **app/Models/IyzicoModel.php**: İyzico API yapılandırma bilgilerini veritabanından çeken model.
- **app/Views/iyzico/**: Ödeme ve doğrulama ile ilgili HTML görünümleri.

- **app/Controllers/Home.php**: The main controller that starts and verifies payment transactions.
- **app/Libraries/Iyzico.php**: Class that handles Iyzico payment and verification processes.
- **app/Models/IyzicoModel.php**: Model that retrieves Iyzico API configuration information from the database.
- **app/Views/iyzico/**: HTML views related to payment and verification.

## Test Ortamı / Test Environment

Bu proje, İyzico'nun **sandbox** ortamında test edilebilir. Test kartı bilgilerini İyzico'nun sunduğu sandbox dokümantasyonundan temin edebilirsiniz. Test kartı bilgileri ile yapacağınız işlemler gerçek ödeme işlemi oluşturmaz.

This project can be tested in Iyzico's **sandbox** environment. You can obtain test card information from Iyzico's sandbox documentation. Transactions made with test card information will not create actual payment transactions.

## Yardım / Help

Sorularınız ve sorunlarınız için İyzico'nun resmi dokümantasyonunu inceleyebilir veya bana ulaşabilirsiniz.

For questions and issues, please review Iyzico's official documentation or contact me.

- İyzico PHP SDK Version: iyzipay-php 2.0.56 

- [İyzico PHP SDK Documentation](https://github.com/iyzico/iyzipay-php)

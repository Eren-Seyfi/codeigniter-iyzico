
# İyzico Ödeme Sistemi Entegrasyonu

Bu proje, İyzico ödeme sistemini CodeIgniter 4 ile entegre ederek, kullanıcıların ödeme yapmasına ve ödeme doğrulama işlemlerinin yapılmasına olanak sağlar. Projede iki farklı ödeme seçeneği mevcuttur: popup ve responsive ödeme formları. Ayrıca ödeme doğrulama işlemleri de gerçekleştirilir.

## Gereksinimler

- PHP 7.4 ve üzeri
- CodeIgniter 4
- Composer
- İyzico PHP SDK

## Kurulum

### 1. Bu projeyi klonlayın:
```bash
git clone https://github.com/kullanici/proje.git
```

### 2. Gerekli bağımlılıkları yükleyin:
Projeyi klonladıktan sonra projenin kök dizininde aşağıdaki komutu çalıştırarak Composer bağımlılıklarını yükleyin:

```bash
composer install
```

### 3. İyzico PHP SDK'yı yükleyin:
```bash
composer require iyzico/iyzipay-php
```

### 4. .env dosyasını yapılandırın:
CodeIgniter projesinde `.env` dosyasını açın ve veritabanı bilgilerini ve base URL gibi ayarları yapılandırın:

```
database.default.hostname = localhost
database.default.database = iyzico_db
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
app.baseURL = 'http://localhost:8080'
```

### 5. Veritabanı Migrations ve Seeds çalıştırın:
Aşağıdaki komutları çalıştırarak veritabanını oluşturun ve gerekli tabloları ekleyin:

```bash
php spark migrate
php spark db:seed IyzicoSeeder
```

### 6. İyzico API Anahtarlarını Yapılandırın:
Veritabanına, `IyzicoSeeder` ile eklenen test API anahtarlarını kullanabilirsiniz. Gerçek API anahtarlarını kullanmak için, `iyzico` tablosundaki `api_key` ve `secret_key` alanlarını güncelleyebilirsiniz.

### 7. Projeyi Başlatın:
Projeyi başlatmak için aşağıdaki komutu kullanın:

```bash
php spark serve
```

## Kullanım

### Adım 1: Ödeme Formu Gösterimi
Aşağıdaki URL'lere giderek farklı ödeme formu seçeneklerini görüntüleyebilirsiniz:

- Responsive Ödeme Formu: [http://localhost:8080/iyzico-responsive](http://localhost:8080/iyzico-responsive)
- Popup Ödeme Formu: [http://localhost:8080/iyzico-popup](http://localhost:8080/iyzico-popup)

### Adım 2: Ödeme Doğrulama
Ödeme tamamlandıktan sonra İyzico, belirlediğiniz `callback_url` üzerinden bir token gönderir. Bu token'ı kullanarak aşağıdaki URL ile ödeme doğrulamasını yapabilirsiniz:

```bash
http://localhost:8080/iyzico-payment-verify
```

Bu URL'yi, ödeme süreci sonunda gönderilen `token` ile çağırdığınızda ödeme doğrulama işlemi yapılacaktır.

## Ödeme Doğrulama
Ödeme doğrulama işlemi, `iyzicoPaymentVerify` fonksiyonu ile gerçekleştirilir. Bu fonksiyon, İyzico'dan gelen token'ı alır ve `verifyPayment` metodunu çağırarak ödeme durumunu sorgular. Eğer ödeme başarılıysa, başarılı bir mesaj, başarısızsa hata mesajı görüntülenir.

### Ödeme Durumunu Sorgulama
- **Başarılı Ödeme**: Ödeme başarılı olduğunda ekranda "Ödeme başarılı" mesajı gösterilir.
- **Başarısız Ödeme**: Ödeme başarısız olduğunda "Ödeme başarısız" mesajı gösterilir.

## Proje Yapısı

- **app/Controllers/Home.php**: Ödeme işlemlerini başlatan ve doğrulayan ana denetleyici.
- **app/Libraries/Iyzico.php**: İyzico ödeme ve doğrulama işlemlerini gerçekleştiren sınıf.
- **app/Models/IyzicoModel.php**: İyzico API yapılandırma bilgilerini veritabanından çeken model.
- **app/Views/iyzico/**: Ödeme ve doğrulama ile ilgili HTML görünümleri.

## Test Ortamı

Bu proje, İyzico'nun **sandbox** ortamında test edilebilir. Test kartı bilgilerini İyzico'nun sunduğu sandbox dokümantasyonundan temin edebilirsiniz. Test kartı bilgileri ile yapacağınız işlemler gerçek ödeme işlemi oluşturmaz.

## Yardım

Sorularınız ve sorunlarınız için İyzico'nun resmi dokümantasyonunu inceleyebilir veya bana ulaşabilirsiniz.

- İyzico PHP SDK Version: iyzipay-php 2.0.56 

- [İyzico PHP SDK Dokümantasyonu](https://github.com/iyzico/iyzipay-php)

# CodeIgniter 4 Spark Komutları

`Spark` komut satırı aracı, CodeIgniter 4'te çeşitli işlemleri hızla gerçekleştirmenizi sağlar. Bu rehber, `spark` komutlarıyla nasıl işlem yapabileceğinizi ve örnek kullanım senaryolarını detaylı olarak anlatır.

## 1. Migration Yönetimi

Migration, veritabanı yapısını kodla yönetmeyi sağlar. Veritabanı şeması değişikliklerini migration'larla yaparak, tüm veritabanı işlemlerini kontrol altında tutabilirsiniz.

### Migration Oluşturma:
```bash
php spark make:migration CreateUsersTable
```
Bu komut, `app/Database/Migrations` dizininde bir migration dosyası oluşturur.

#### Örnek Migration Kodu:
```php
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // Yeni bir tablo oluşturma
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT', // Alan tipi
                'constraint'     => 5, // Alanın maksimum değeri
                'unsigned'       => true, // Pozitif değer
                'auto_increment' => true, // Otomatik artış
            ],
            'username'    => [
                'type'       => 'VARCHAR', // Alan tipi
                'constraint' => '100', // Maksimum karakter sayısı
            ],
            'password'    => [
                'type'       => 'VARCHAR', // Alan tipi
                'constraint' => '255', // Maksimum karakter sayısı
            ],
            'created_at'  => [
                'type' => 'DATETIME', // Tarih ve zaman
                'null' => true, // Null değer alabilir
            ],
            'updated_at'  => [
                'type' => 'DATETIME', // Tarih ve zaman
                'null' => true, // Null değer alabilir
            ],
        ]);

        // Anahtar tanımlama
        $this->forge->addKey('id', true); // id alanını anahtar olarak belirleme
        $this->forge->createTable('users'); // users tablosunu oluşturma
    }

    public function down()
    {
        // Tabloyu silme
        $this->forge->dropTable('users');
    }
}

```

### Migration'ları Uygulama:
```bash
php spark migrate
```
Bu komut, veritabanına tüm migration'ları uygular ve tabloları oluşturur.

### Migration Geri Alma (Rollback):
```bash
php spark migrate:rollback
```
Bu komut, en son yapılan migration'ı geri alır. Eğer daha önce bir tablo oluşturulduysa, bu tablo kaldırılır.

### Migration Durumunu Görüntüleme:
```bash
php spark migrate:status
```
Bu komut, hangi migration'ların çalıştırıldığını ve hangilerinin beklemede olduğunu gösterir.

---

## 2. Model Oluşturma

CodeIgniter 4'te modeller, veritabanıyla etkileşim kurmanızı sağlar. Modelleri kullanarak veri alabilir, ekleyebilir, güncelleyebilir ve silebilirsiniz.

### Model Oluşturma:
```bash
php spark make:model UserModel
```
Bu komut, `app/Models` dizininde bir model oluşturur.

#### Örnek Model Kodu:
```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Modelin çalışacağı tablo adı
    protected $primaryKey = 'id'; // Tablo üzerindeki birincil anahtar
    protected $allowedFields = ['username', 'password']; // Ekleme/ güncelleme için izin verilen alanlar
    protected $useTimestamps = true; // Zaman damgalarını otomatik olarak kullanma
}

```
Bu model, `users` tablosuyla çalışır ve `username`, `password` alanlarına veri eklenmesine izin verir.

### Model Kullanımı:
```php
$userModel = new \App\Models\UserModel(); // Modeli başlatma

// Veritabanına yeni bir kullanıcı ekleme
$userModel->save([
    'username' => 'testuser', // Kullanıcı adı
    'password' => password_hash('123456', PASSWORD_BCRYPT), // Şifreyi hashleme
]);

// Tüm kullanıcıları listeleme
$users = $userModel->findAll(); // Tüm kullanıcıları alma

// Belirli bir kullanıcıyı ID ile bulma
$user = $userModel->find(1); // ID'si 1 olan kullanıcıyı bulma

// Kullanıcıyı güncelleme
$userModel->update(1, ['username' => 'updateduser']); // ID'si 1 olan kullanıcının adını güncelleme

// Kullanıcıyı silme
$userModel->delete(1); // ID'si 1 olan kullanıcıyı silme

```

---

## 3. Controller Oluşturma

Controller'lar, istekleri karşılayıp gerekli işlemleri yapan ve sonuçları döndüren sınıflardır.

### Controller Oluşturma:
```bash
php spark make:controller UsersController
```
Bu komut, `app/Controllers` dizininde bir controller oluşturur.

#### Örnek Controller Kodu:
```php
<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel(); // Modeli başlatma
        $data['users'] = $userModel->findAll(); // Tüm kullanıcıları alma
        
        return view('users/index', $data); // Kullanıcıları görüntüleme
    }
    
    public function create()
    {
        return view('users/create'); // Kullanıcı oluşturma formunu görüntüleme
    }
    
    public function store()
    {
        $userModel = new UserModel(); // Modeli başlatma
        $userModel->save([
            'username' => $this->request->getPost('username'), // Formdan gelen kullanıcı adı
            'password'

```

### RESTful Controller:
```bash
php spark make:controller UsersController --restful
```
Bu komut, CRUD işlemleri için kullanılabilecek bir RESTful controller oluşturur.

---

## 4. Seeder Oluşturma

Seeders, veritabanına başlangıç verileri eklemek için kullanılır.

### Seeder Oluşturma:
```bash
php spark make:seeder UserSeeder
```

#### Örnek Seeder Kodu:
```php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin', // Başlangıç kullanıcı adı
            'password' => password_hash('admin123', PASSWORD_BCRYPT), // Başlangıç şifresi
        ];

        // Veritabanına kayıt ekleme
        $this->db->table('users')->insert($data); // Kullanıcıyı veritabanına ekleme
    }
}

```

### Seeder'ı Çalıştırma:
```bash
php spark db:seed UserSeeder
```

---

## 5. Entity Oluşturma

Entity'ler, veritabanı kayıtlarını nesne şeklinde temsil eder ve veri manipülasyonunu kolaylaştırır.

### Entity Oluşturma:
```bash
php spark make:entity UserEntity
```

#### Örnek Entity Kodu:
```php
<?php

namespace App\Entities;

use CodeIgniter\Entity;

class UserEntity extends Entity
{
    protected $attributes = [
        'id' => null, // Kullanıcı ID'si
        'username' => null, // Kullanıcı adı
        'password' => null, // Şifre
    ];

    public function setPassword(string $password)
    {
        // Şifreyi hashleyerek atama
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
        return $this; // Mevcut nesneyi döndürme
    }
}

```

---

## 6. Filter Oluşturma

Filtreler, gelen ve giden isteklerde ek işlemler yapmanızı sağlar.

### Filter Oluşturma:
```bash
php spark make:filter AuthFilter
```

#### Örnek Filter Kodu:
```php
<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Kullanıcı oturum açmamışsa yönlendir
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Giriş sayfasına yönlendirme
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // İşlem sonrası yapılacak işlemler
    }
}

```

---

## 7. Task Scheduler (Görev Zamanlayıcı)

Zamanlanmış görevler oluşturmak için kullanılır.

### Görev Tanımlama:
```bash
php spark make:task CleanupTask
```

#### Örnek Task Kodu:
```php
<?php

namespace App\Tasks;

class CleanupTask
{
    public function run()
    {
        // Belirli aralıklarla yapılacak görevler burada tanımlanır.
        log_message('info', 'Cleanup task running...'); // Log kaydı
    }
}

```

### Görev Çalıştırma:
```bash
php spark tasks:run
```

---

## 8. Yerel Geliştirme Sunucusu Başlatma

Yerel geliştirme sunucusunu başlatmak için kullanılır. Uygulamanızı yerel olarak test edebilirsiniz.

### Sunucu Başlatma:
```bash
php spark serve
```

### Özel Port Belirtme:
```bash
php spark serve --port=8081
```
Bu komut, sunucuyu belirtilen portta çalıştırır (örneğin, `http://localhost:8081`).

---

## 9. Diğer Faydalı Spark Komutları

### Veritabanı Yedekleme:
```bash
php spark db:backup
```
Veritabanını yedekler ve bir `.sql` dosyası oluşturur.

### Rota Kontrolü:
```bash
php spark routes
```
Tüm tanımlı rotaları ve bunların nereye yönlendirildiğini listeler.

### Ortam Kontrolü:
```bash
php spark env
```
Çalışan ortam (development, production vb.) bilgisini gösterir.

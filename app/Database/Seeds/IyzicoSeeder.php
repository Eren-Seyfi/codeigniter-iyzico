<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IyzicoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'api_key' => 'sandbox-frr2cuCQESKbqwdcE03P5Dgs9WLKxQhT',
            'secret_key' => '4NWuz28qzsW8qWqU0dtBJls8Vsrt5JKq',
            'base_url_test' => 'https://sandbox-api.iyzipay.com',
            'base_url_production' => 'https://api.iyzipay.com',
            'callback_url' => 'https://yourdomain.com/callback', // Callback URL ekleniyor
            'status' => 'test', // Varsayılan olarak test ortamı
            'created_at' => date('Y-m-d H:i:s'), // Otomatik zaman damgası
            'updated_at' => date('Y-m-d H:i:s'), // Otomatik zaman damgası
        ];

        // Veritabanına kayıt ekleme
        $this->db->table('iyzico')->insert($data);
    }
}

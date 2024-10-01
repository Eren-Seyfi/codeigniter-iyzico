<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Libraries\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin', // Başlangıç kullanıcı adı
            'email' => 'admin@example.com', // Başlangıç kullanıcı adı
            'password' => Hash::encrypt_password('admin'), // Başlangıç şifresi
        ];

        // Veritabanına kayıt ekleme
        $this->db->table('users')->insert($data); // Kullanıcıyı veritabanına ekleme
    }
}
?>
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // Yeni bir tablo oluşturma
        $this->forge->addField([
            'id' => [
                'type' => 'INT', // Alan tipi
                'constraint' => 5, // Alanın maksimum değeri
                'unsigned' => true, // Pozitif değer
                'auto_increment' => true, // Otomatik artış
            ],
            'username' => [
                'type' => 'VARCHAR', // Alan tipi
                'constraint' => '100', // Maksimum karakter sayısı
            ],
            'email' => [
                'type' => 'VARCHAR', // Alan tipi
                'constraint' => '100', // Maksimum karakter sayısı
                'unique' => true, // Benzersiz alan yapma
            ],
            'password' => [
                'type' => 'VARCHAR', // Alan tipi
                'constraint' => '255', // Maksimum karakter sayısı
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP', // Tarih ve zaman
                'default' => new RawSql('CURRENT_TIMESTAMP'), // Varsayılan olarak o anki zamanı alır
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

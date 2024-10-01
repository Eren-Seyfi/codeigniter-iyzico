<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateIyzicoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'api_key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'secret_key' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'base_url_test' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'base_url_production' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'callback_url' => [  // Yeni callback URL alanı
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['test', 'production'],
                'default' => 'test',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('iyzico');
    }

    public function down()
    {
        $this->forge->dropTable('iyzico');
    }
}

<?php
namespace App\Models;

use CodeIgniter\Model;

class IyzicoModel extends Model
{
    protected $table = 'iyzico';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['api_key', 'secret_key', 'base_url_test', 'base_url_production', 'callback_url', 'status', 'created_at', 'updated_at'];

    public function getConfig()
    {
        return $this->first(); // İlk kaydı döndür
    }
}

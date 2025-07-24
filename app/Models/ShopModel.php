<?php
namespace App\Models;
use CodeIgniter\Model;
class ShopModel extends Model{
    protected $table = 'products';
    protected $primaryKey = 'ProductId';
    protected $allowedFields = ['name', 'image', 'price','description'];
}
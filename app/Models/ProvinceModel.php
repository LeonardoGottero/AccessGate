<?php
namespace App\Models;
use CodeIgniter\Model;
class ProvinceModel extends Model{
    protected $table = 'province';
    protected $primaryKey = 'ProvinceId';
    protected $allowedFields = ['province'];
}
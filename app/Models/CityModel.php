<?php
namespace App\Models;
use CodeIgniter\Model;
class CityModel extends Model{
    protected $table = 'cities';
    protected $primaryKey = 'CityId';
    protected $allowedFields = ['ProvinceId', 'city'];
}
<?php
namespace App\Models;
use CodeIgniter\Model;
class DUModel extends Model{
    protected $table = 'd-u';
    protected $primaryKey = 'D-UId';
    protected $allowedFields = ['DeviceId', 'UserId', 'allowed'];
}
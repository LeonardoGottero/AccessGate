<?php
namespace App\Models;
use CodeIgniter\Model;
class DeviceModel extends Model{
    protected $table = 'devices';
    protected $primaryKey = 'DeviceId';
    protected $allowedFields = ['device_name', 'device_uid', 'AccountId', 'Status'];
    public function DeviceExists($Deviceuid, $DeviceId, $AccountId){
        return $this->where('device_uid', $Deviceuid)
                    ->where('DeviceId !=', $DeviceId)
                    ->where('AccountId !=', $AccountId)
                    ->first() !== null;
    }
}
<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model{
    protected $table = 'users'; 
    protected $primaryKey = 'UserId'; 
    protected $allowedFields = ['name','surname','email','tag','token','from_time','to_time','allowed_days','AccountId'];
    public function tagExists($tag, $userId) {
        return $this->where('tag', $tag)
                    ->where('UserId !=', $userId)
                    ->first() !== null;
    }
}    
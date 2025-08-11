<?php
namespace App\Models;
use CodeIgniter\Model;
class AccountModel extends Model{
    protected $table = 'account';
    protected $primaryKey = 'AccountId';
    protected $allowedFields = ['accountname','email', 'password','is_active','token','token_created_at','reset_token','reset_token_expires','rol', 'totp_secret'];
    protected $beforeInsert = ['HashPassword'];
    protected $beforeUpdate = ['HashPassword'];
    protected function HashPassword(array $Data){
        if (isset($Data['data']['password'])) {
            $Data['data']['password'] = password_hash($Data['data']['password'], PASSWORD_DEFAULT);
        }
        return $Data;
    }
    public function EmailExists($Email) {
        return $this->where('email', $Email)->first() !== null;
    }
    public function AccountnameExists($Accountname) {
        return $this->where('accountname', $Accountname)->first() !== null;
    }
}
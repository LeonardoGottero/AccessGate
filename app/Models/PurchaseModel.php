<?php
namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases'; 
    protected $primaryKey = 'PurchaseId';
    protected $allowedFields = [
        'AccountId',
        'ProductId',
        'paypal_order_id',
        'paypal_transaction_id',
        'amount',
        'status',
        'created_at',
        'updated_at',
        'complete_name',
        'address',
        'phone',
        'province', 
        'city'
    ];

    protected $useTimestamps = false; 
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPurchasesByAccountId($AccountId)
    {
        return $this->select('purchases.*, products.name as product_name')
                    ->join('products', 'products.ProductId = purchases.ProductId')
                    ->where('purchases.AccountId', $AccountId)
                    ->orderBy('purchases.created_at', 'DESC')
                    ->findAll();
    }
}
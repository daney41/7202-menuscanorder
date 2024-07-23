<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table            = 'OrderDetails';
    protected $primaryKey       = 'order_detail_id';
    protected $allowedFields = ['order_id','dish_id','customization_id', 'quantity', 'milk_id'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}
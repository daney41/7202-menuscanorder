<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table            = 'Orders';
    protected $primaryKey       = 'order_id';
    protected $allowedFields = ['user_id','table_id','total_price', 'status'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields

    public function getCompleteOrderDetails($table_id) {
        $builder = $this->db->table('Orders');
        $builder->select('
        Orders.user_id,
        Orders.order_id, 
        Orders.total_price, 
        Orders.status, 
        Tables.table_name,
        Dishes.dish_id, 
        Dishes.dish_name, 
        Dishes.price, 
        OrderDetails.quantity,
        Milks.milk_type,
        Customizations.customization_id, 
        Customizations.customization
    ');
        $builder->join('OrderDetails', 'Orders.order_id = OrderDetails.order_id', 'inner');
        $builder->join('Tables', 'Orders.table_id = Tables.table_id', 'inner');
        $builder->join('Dishes', 'OrderDetails.dish_id = Dishes.dish_id', 'inner');
        $builder->join('Customizations', 'OrderDetails.customization_id = Customizations.customization_id', 'left'); // some dishes don't have customization.
        $builder->join('Milks', 'OrderDetails.milk_id = Milks.milk_id', 'left');
        $builder->where('Orders.table_id', $table_id);

        $query = $builder->get();

        return $query->getResultArray(); // 返回结果数组
    }
}
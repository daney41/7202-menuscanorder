<?php

namespace App\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table            = 'Tables';
    protected $primaryKey       = 'table_id';
    protected $allowedFields = ['user_id','status','table_name'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields

    public function getTablesWithOrders($user_id) {
        $builder = $this->db->table('Tables');
        $builder->select('
            Tables.table_id, 
            Tables.user_id, 
            Tables.table_name, 
            Tables.status,
            Orders.order_id, 
            Orders.total_price, 
            Orders.status AS order_status 
        ');
        $builder->join('Orders', 'Tables.table_id = Orders.table_id', 'left'); // left join all the table
        $builder->where('Tables.user_id', $user_id);
        $query = $builder->get();

        return $query->getResultArray(); // return the table with order
    }

    public function getSpecificTablesOrders($table_id) {
        $builder = $this->db->table('Tables');
        $builder->select('
            Tables.table_id, 
            Tables.user_id, 
            Tables.table_name, 
            Tables.status,
            Orders.order_id, 
            Orders.total_price, 
            Orders.status AS order_status 
        ');
        $builder->join('Orders', 'Tables.table_id = Orders.table_id', 'left'); // left join all the table
        $builder->where('Tables.table_id', $table_id);
        $query = $builder->get();

        $result = $query->getResultArray(); // return the table with order
        return $result[0];
    }
}
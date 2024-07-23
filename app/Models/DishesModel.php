<?php

namespace App\Models;

use CodeIgniter\Model;

class DishesModel extends Model
{
    protected $table            = 'Dishes';
    protected $primaryKey       = 'dish_id';
    protected $allowedFields = ['menu_id','dish_name','description', 'price', 'category_id'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields

    public function getDishesExcludingNotSelected()
    {
        $builder = $this->db->table($this->table);
        $builder->select('dishes.*, category.name as category_name');
        $builder->join('category', 'category.category_id = dishes.category_id');
        $builder->where('category.name !=', 'not selected');
        $builder->orderBy('category.name', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}

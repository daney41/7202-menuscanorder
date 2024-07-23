<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'Category'; // Set to your actual table name
    protected $primaryKey = 'category_id'; 
    protected $allowedFields = ['name'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}
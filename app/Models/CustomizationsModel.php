<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomizationsModel extends Model
{
    protected $table = 'Customizations'; // Set to your actual table name
    protected $primaryKey = 'customization_id'; 
    protected $allowedFields = ['dish_id','customization'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}
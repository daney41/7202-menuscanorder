<?php

namespace App\Models;

use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table            = 'Menus';
    protected $primaryKey       = 'menu_id';
    protected $allowedFields = ['user_id','menu_name','description'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}
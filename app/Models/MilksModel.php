<?php

namespace App\Models;

use CodeIgniter\Model;

class MilksModel extends Model
{
    protected $table            = 'Milks';
    protected $primaryKey       = 'milk_id';
    protected $allowedFields = ['milk_type'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}
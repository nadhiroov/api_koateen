<?php

namespace App\Models;

use CodeIgniter\Model;

class M_koachef extends Model
{
    protected $table            = 'koachef';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'title', 'ingredients', 'nutrisions', 'cook', 'calories', 'image', 'creator_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class M_userdata extends Model
{
    protected $table            = 'userdata';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['userId', 'units', 'gender', 'weight', 'age', 'height', 'level', 'bmi', 'bmiLevel', 'dayDate'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

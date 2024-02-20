<?php

namespace App\Models;

use CodeIgniter\Model;

class M_siklushaid extends Model
{
    protected $table            = 'siklus_haid';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['userId', 'startDate', 'endDate'];

    // Dates
    protected $useTimestamps = false;
}

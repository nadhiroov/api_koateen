<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alteruserdata extends Migration
{
    protected $tableName  = 'userdata';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'dayDate' => [
                'type'      => 'DATE',
                'null'      => true,
                'default'   => null
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'dayDate');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alterkoachef extends Migration
{
    protected $tableName  = 'koachef';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'target' => [
                'type'      => 'VARCHAR',
                'constraint'=> 100,
                'default'   => null,
                'null'      => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'target');
    }
}

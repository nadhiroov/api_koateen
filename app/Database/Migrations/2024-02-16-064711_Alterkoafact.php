<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alterkoafact extends Migration
{
    protected $tableName  = 'koafacts';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default'   => null,
                'null'      => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'image');
    }
}

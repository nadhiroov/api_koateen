<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alteruserdata extends Migration
{
    protected $tableName  = 'userdata';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'recommendation' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => null,
                'null' => true,
            ],
            'bmr' => [
                'type' => 'DOUBLE',
                'default' => null,
                'null' => true,
            ],
            'needCalories' => [
                'type' => 'DOUBLE',
                'default' => null,
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'recommendation');
        $this->forge->dropColumn($this->tableName, 'bmr');
        $this->forge->dropColumn($this->tableName, 'needCalories');
    }
}

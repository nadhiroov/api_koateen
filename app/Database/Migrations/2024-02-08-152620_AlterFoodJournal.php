<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFoodJournal extends Migration
{
    protected $tableName  = 'food_journal';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'weight' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => null,
                'null' => true,
            ],
            'cal' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => null,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'weight');
        $this->forge->dropColumn($this->tableName, 'cal');
    }
}

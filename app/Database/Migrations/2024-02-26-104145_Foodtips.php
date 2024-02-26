<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Foodtips extends Migration
{
    protected $tableName  = 'food_tips';
    public function up()
    {
        $this->forge->addField([
            'id' => array(
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'auto_increment' => true
            ),
            'title' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
                'default' => null,
            ],
            'content' => [
                'type'  => 'LONGTEXT',
                'null'  => true,
                'default' => null,
            ],
            'contain' => [
                'type'  => 'VARCHAR',
                'constraint' => 100,
                'null'  => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createtable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName);
    }
}

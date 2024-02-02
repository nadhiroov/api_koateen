<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Koachef extends Migration
{
    protected $tableName  = 'koachef';
    public function up()
    {
        $this->forge->addField([
            'id' => array(
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'auto_increment' => true
            ),
            'type' => [
                'type' => 'ENUM("Breakfast","Launch","Dinner")',
                'default' => null,
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'ingredients' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nutrisions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cook' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'calories' => [
                'type'      => 'INT',
                'constraint'=> 5,
                'unsigned'  => true,
                'null'      => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'creator_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned'      => true,
                'null' => true,
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

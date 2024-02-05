<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Foodmenu extends Migration
{
    protected $tableName  = 'koafood';
    public function up()
    {
        $this->forge->addField([
            'id' => array(
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'auto_increment' => true
            ),
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
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

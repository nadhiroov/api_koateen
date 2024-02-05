<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Foodjournal extends Migration
{
    protected $tableName  = 'food_journal';
    public function up()
    {
        $this->forge->addField([
            'id' => array(
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'auto_increment' => true
            ),
            'userId' => [
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
            ],
            'foodId' => [
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => null,
                'null' => true,
            ],
            'day' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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
        $this->forge->addForeignKey('userId', 'm_users', 'id');
        $this->forge->addForeignKey('foodId', 'koafood', 'id');
        $this->forge->createtable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Koafacts extends Migration
{
    protected $tableName  = 'koafacts';
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
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
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

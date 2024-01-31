<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Koafit extends Migration
{
    protected $tableName  = 'koafit';
    public function up()
    {
        $this->forge->addField([
            'id' => array(
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'auto_increment' => true
            ),
            'sport' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'kkal' => [
                'type' => 'INT',
                'constraint' => 5,
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

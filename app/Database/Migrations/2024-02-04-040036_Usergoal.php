<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usergoal extends Migration
{
    protected $tableName  = 'usergoal';
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
            'want' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null,
                'null' => true,
            ],
            'weightGoal' => [
                'type' => 'ENUM("Yes","No")',
                'default' => null,
                'null' => true,
            ],
            'weight' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => null,
                'null' => true,
            ],
            'diet' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createtable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName);
    }
}

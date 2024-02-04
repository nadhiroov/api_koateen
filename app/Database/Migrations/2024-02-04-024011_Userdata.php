<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Userdata extends Migration
{
    protected $tableName  = 'userdata';
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
            'units' => [
                'type' => 'ENUM("US Standart","Metric")',
                'default' => null,
                'null' => true,
            ],
            'gender' => [
                'type' => 'ENUM("Male","Female")',
                'default' => null,
                'null' => true,
            ],
            'weight' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => null,
                'null' => true,
            ],
            'age' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => null,
                'null' => true,
            ],
            'height' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => null,
                'null' => true,
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null,
                'null' => true,
            ],
            'bmi' => [
                'type' => 'DOUBLE',
                'default' => null,
                'null' => true,
            ],
            'bmiLevel' => [
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

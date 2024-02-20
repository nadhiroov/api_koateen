<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tbsiklushaid extends Migration
{
    protected $tableName  = 'siklus_haid';
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
            'startDate' => [
                'type'  => 'DATE',
                'null'  => true,
            ],
            'endDate' => [
                'type'  => 'DATE',
                'null'  => true,
            ]
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

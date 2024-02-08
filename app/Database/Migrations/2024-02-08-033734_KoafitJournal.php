<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KoafitJournal extends Migration
{
    protected $tableName  = 'koafit_journal';
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
            'koafitId' => [
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
            ],
            'day' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'percent' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'cal' => [
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
        $this->forge->addForeignKey('userId', 'm_users', 'id');
        $this->forge->addForeignKey('koafitId', 'koafit', 'id');
        $this->forge->createtable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName);
    }
}

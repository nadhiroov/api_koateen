<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alterfoodmenu extends Migration
{
    protected $tableName  = 'koafood';
    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'userId' => [
                'type'          => 'INT',
                'constraint'    => 5,
                'unsigned'      => true,
                'default' => null,
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'userId');
    }
}

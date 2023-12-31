<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Login extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'TEXT',
                'constraint' => 255
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('login');
    }

    public function down()
    {
        $this->forge->dropTable('login');
    }
}

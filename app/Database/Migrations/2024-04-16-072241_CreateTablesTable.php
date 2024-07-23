<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablesTable extends Migration
{
    public function up()
    {
    // Define the Tables table
    $this->forge->addField([
        'table_id' => [
            'type' => 'INT',
            'constraint' => 10,
            'unsigned' => TRUE,
            'auto_increment' => TRUE,
        ],
        'user_id' => [
            'type' => 'INT',
            'constraint' => 10,
            'unsigned' => TRUE,
        ],
        'status' => [
            'type' => "ENUM",
            'constraint' => ['Available','Occupied'],
            'default' => 'Available',
        ],
        'table_name' => [
            'type' => 'varchar',
            'constraint' => 100,
        ]

    ]);

    $this->forge->addKey(['table_id','user_id'], TRUE); // Set table_id and user_id as primary key
    $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('Tables'); // Create the Tables table
    }

    public function down()
    {
    // Drop the Tables table if needed
    $this->forge->dropTable('Tables');
    }
}

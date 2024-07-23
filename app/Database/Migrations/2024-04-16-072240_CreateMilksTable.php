<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMilksTable extends Migration
{
    public function up()
    {
        // Define the Milks table
        $this->forge->addField([
            'milk_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'milk_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

        ]);
        
        $this->forge->addKey('milk_id', TRUE); // Set milk_id and user_id as primary key
        $this->forge->createTable('Milks'); // Create the Milks table
    }

    public function down()
    {
        // Drop the Milks table if needed
        $this->forge->dropTable('Milks');
    }
}

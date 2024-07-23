<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomizationsTablephp extends Migration
{
    public function up()
    {
        // Define the Customizations table
        $this->forge->addField([
            'customization_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'dish_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ],
            'customization' => [
                'type' => 'TEXT',
            ],
        ]);
        
        $this->forge->addKey('customization_id', TRUE); // Set customization_id as primary key
        $this->forge->addForeignKey('dish_id', 'Dishes', 'dish_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Customizations'); // Create the Customizations table
    }

    public function down()
    {
        // Drop the Customizations table if needed
        $this->forge->dropTable('Customizations');
    }
}

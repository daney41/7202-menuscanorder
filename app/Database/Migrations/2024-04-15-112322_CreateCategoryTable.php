<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        // Define the Category table
        $this->forge->addField([
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('category_id', TRUE); // Set category_id as primary key
        $this->forge->createTable('Category'); // Create the Category table
    }

    public function down()
    {
        // Drop the Category table if needed
        $this->forge->dropTable('Category');
    }
}

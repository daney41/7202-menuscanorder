<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenusTable extends Migration
{
    public function up()
    {
        // Define the Menu table
        $this->forge->addField([
            'menu_id' => [
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
            'menu_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
            ],

        ]);
        
        $this->forge->addKey(['menu_id','user_id'], TRUE); // Set menu_id and user_id as primary key
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Menus'); // Create the Menu table
    }

    public function down()
    {
        // Drop the Menu table if needed
        $this->forge->dropTable('Menus');
    }
}

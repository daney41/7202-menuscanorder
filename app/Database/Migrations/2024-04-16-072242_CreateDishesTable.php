<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDishesTable extends Migration
{
    public function up()
    {
        // Define the Dishes table
        $this->forge->addField([
            'dish_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'menu_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ],
            'dish_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'price' => [
                'type' => 'decimal',
                'constraint' => '10,2',
                'unsigned' => TRUE,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
        ]);
        
        $this->forge->addKey(['dish_id','menu_id'], TRUE); // Set menu_id and user_id as primary key
        $this->forge->addForeignKey('menu_id', 'Menus', 'menu_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'Category', 'category_id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('Dishes'); // Create the Dishes table
    }

    public function down()
    {
        // Drop the Dishes table if needed
        $this->forge->dropTable('Dishes');
    }
}

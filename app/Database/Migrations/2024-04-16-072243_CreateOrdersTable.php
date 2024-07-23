<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        // Define the Order table
        $this->forge->addField([
            'order_id' => [
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
            'table_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ],
            'total_price' => [
                'type' => 'decimal',
                'constraint' => '10,2',
                'unsigned' => TRUE,
                'default' => 0.00,
            ],
            'status' => [
                'type' => "ENUM",
                'constraint' => ['Received','Preparing', 'Completed'],
                'default' => 'Received',
            ],

        ]);
        
        $this->forge->addKey(['order_id','user_id'], TRUE); // Set order_id and user_id as primary key
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('table_id', 'Tables', 'table_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Orders'); // Create the Order table
    }

    public function down()
    {
        // Drop the Order table if needed
        $this->forge->dropTable('Orders');
    }
}

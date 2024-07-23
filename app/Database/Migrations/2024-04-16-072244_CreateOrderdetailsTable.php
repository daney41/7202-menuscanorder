<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderdetailsTable extends Migration
{
    public function up()
    {
        // 定義 OrderDetails 表
        $this->forge->addField([
            'order_detail_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ],
            'dish_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ],
            'customization_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'milk_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE,
            ],
            'quantity' => [
                'type' => "INT",
                'constraint' => 10,
                'default' => 0,
                'unsigned' => TRUE,
            ],
        ]);

        $this->forge->addKey('order_detail_id', TRUE); // 設置 order_detail_id 為主鍵
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dish_id', 'Dishes', 'dish_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('milk_id', 'Milks', 'milk_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('customization_id', 'Customizations', 'customization_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('OrderDetails'); // 建立 OrderDetails 表
    }

    public function down()
    {
        // 如果需要，刪除 OrderDetails 表
        $this->forge->dropTable('OrderDetails');
    }
}

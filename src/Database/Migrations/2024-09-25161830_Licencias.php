<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Licencias extends Migration {

    public function up() {
        // Licencias
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'idEmpresa' => ['type' => 'bigint', 'constraint' => 20, 'null' => true],
            'descripcion' => ['type' => 'varchar', 'constraint' => 64, 'null' => true],
            'desdeFecha' => ['type' => 'date', 'null' => true],
            'hastaFecha' => ['type' => 'date', 'null' => true],
            'claveModulo' => ['type' => 'varchar', 'constraint' => 16, 'null' => true],
            'licencia' => ['type' => 'varchar', 'constraint' => 128, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('licencias', true);
    }

    public function down() {
        $this->forge->dropTable('licencias', true);
    }
}

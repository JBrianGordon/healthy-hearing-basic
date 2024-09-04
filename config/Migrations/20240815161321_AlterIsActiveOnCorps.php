<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterIsActiveOnCorps extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('corps');
        $table->changeColumn('is_active', 'boolean', [
            'default' => false,
            'limit' => null,
            'null' => false,
        ]);
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('corps');
        $table->changeColumn('is_active', 'boolean', [
            'default' => true,
            'limit' => null,
            'null' => false,
        ]);
        $table->update();
    }
}

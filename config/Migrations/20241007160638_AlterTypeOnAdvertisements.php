<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AlterTypeOnAdvertisements extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('advertisements');
        $table->changeColumn('type', 'string', [
            'default' => '',
            'limit' => 16,
            'null' => false,
        ]);
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('advertisements');
        $table->changeColumn('type', 'string', [
            'default' =>'',
            'limit' => 8,
            'null' => false,
        ]);
        $table->update();
    }
}
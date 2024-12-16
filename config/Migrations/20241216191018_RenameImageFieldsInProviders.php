<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameImageFieldsInProviders extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('providers');
        $table->renameColumn('square_url', 'photo_name')
            ->renameColumn('public_url', 'photo_url');
        $table->update();
    }

    public function down(): void
    {
        $table = $this->table('providers');
        $table->renameColumn('photo_name', 'square_url')
            ->renameColumn('photo_url', 'public_url');
        $table->update();
    }
}

<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddTitleToImportProviders extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('import_providers');
        $table->addColumn('title', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'aud_or_his',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('import_providers');
        $table->removeColumn('title');
        $table->save();
    }
}

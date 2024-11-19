<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddPublicUrlToProviders extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('providers');
        $table->addColumn('public_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'thumb_url',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('providers');
        $table->removeColumn('public_url');
        $table->save();
    }
}

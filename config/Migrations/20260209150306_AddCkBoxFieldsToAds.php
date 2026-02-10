<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddCkBoxFieldsToAds extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('advertisements');
        $table->addColumn('image_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'title',
            ]);
        $table->addColumn('image_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'image_name',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('advertisements');
        $table->removeColumn('image_name');
        $table->removeColumn('image_url');
        $table->save();
    }
}

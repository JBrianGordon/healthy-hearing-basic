<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddCkBoxFieldsToWikis extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('wikis');
        $table->addColumn('facebook_image_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'facebook_image',
            ]);
        $table->addColumn('facebook_image_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'facebook_image_name',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('wikis');
        $table->removeColumn('facebook_image_name');
        $table->removeColumn('facebook_image_url');
        $table->save();
    }
}

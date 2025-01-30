<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddCkBoxFieldsToCorps extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('corps');
        $table->addColumn('logo_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'description',
            ]);
        $table->addColumn('logo_url', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'logo_name',
            ]);
        $table->addColumn('facebook_image_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'facebook_description',
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
        $table = $this->table('corps');
        $table->removeColumn('logo_name');
        $table->removeColumn('logo_url');
        $table->removeColumn('facebook_image_name');
        $table->removeColumn('facebook_image_url');
        $table->save();
    }
}

<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddLogoNameToLocations extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('locations');
        $table->addColumn('logo_name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => true,
                'after' => 'email',
            ]);
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('locations');
        $table->removeColumn('logo_name');
        $table->save();
    }
}

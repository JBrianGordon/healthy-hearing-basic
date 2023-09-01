<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddLocationCountToProviders extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('providers');
        $table->addColumn('location_count', 'integer', [
            'default' => 0,
            // 'limit' => 255,
            'null' => false,
            'after' => 'id_yhn_provider',
        ]);
        $table->save();

        // Populate the location_count column
        $this->execute('UPDATE providers p SET location_count = (SELECT COUNT(*) FROM locations_providers lp WHERE lp.provider_id = p.id)');
    }

    public function down()
    {
        $table = $this->table('providers');
        $table->removeColumn('location_count');
        $table->save();
    }
}

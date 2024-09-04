<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveIsBypassedFromLocations extends AbstractMigration
{
/**
     * Migrate Up.
     */
    public function up()
    {
        // Remove is_bypassed from Locations table
        $table = $this->table('locations');
        $table->removeColumn('is_bypassed');
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('locations');
        $table->addColumn('is_bypassed', 'boolean');
        $table->save();
    }
}

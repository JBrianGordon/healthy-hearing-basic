<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveIsIdaVerifiedFromLocationsAndProviders extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // Remove is_ida_verified from locations table
        $locationsTable = $this->table('locations');
        $locationsTable->removeColumn('is_ida_verified');
        $locationsTable->save();

        // Remove is_ida_verified from providers table
        $providersTable = $this->table('providers');
        $providersTable->removeColumn('is_ida_verified');
        $providersTable->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        // Add is_ida_verified back to locations table
        $locationsTable = $this->table('locations');
        $locationsTable->addColumn('is_ida_verified', 'boolean');
        $locationsTable->save();

        // Add is_ida_verified back to providers table
        $providersTable = $this->table('providers');
        $providersTable->addColumn('is_ida_verified', 'boolean');
        $providersTable->save();
    }
}
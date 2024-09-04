<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveMiddleNameFromUsers extends AbstractMigration
{
/**
     * Migrate Up.
     */
    public function up()
    {
        // Remove middle_name from Users table
        $table = $this->table('users');
        $table->removeColumn('middle_name');
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('users');
        $table->addColumn('middle_name', 'boolean');
        $table->save();
    }
}

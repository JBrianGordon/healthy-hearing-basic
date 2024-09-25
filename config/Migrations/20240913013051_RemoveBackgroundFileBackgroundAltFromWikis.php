<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveBackgroundFileBackgroundAltFromWikis extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('wikis');
        $table->removeColumn('background_file');
        $table->removeColumn('background_alt');
        $table->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $table = $this->table('wikis');
        $table->addColumn('background_file', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('background_alt', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => false,
        ]);
        $table->save();
    }
}

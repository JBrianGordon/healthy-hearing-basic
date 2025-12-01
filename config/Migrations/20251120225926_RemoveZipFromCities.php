<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveZipFromCities extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('cities');
        $table->removeColumn('zip');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('cities');
        $table->addColumn('zip', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => true,
            'after' => 'state',
        ]);
        $table->save();
    }
}

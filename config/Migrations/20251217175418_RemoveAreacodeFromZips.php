<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveAreacodeFromZips extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('zips');
        $table->removeColumn('areacode');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('zips');
        $table->addColumn('areacode', 'string', [
            'default' => null,
            'limit' => 3,
            'null' => false,
            'after' => 'state',
        ]);
        $table->save();
    }
}

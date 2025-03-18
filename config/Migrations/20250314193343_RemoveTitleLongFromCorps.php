<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveTitleLongFromCorps extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('corps');
        $table->removeColumn('title_long');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('corps');
        $table->addColumn('title_long', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'after' => 'title',
        ]);

        $table->save();
    }
}

<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveDateApprovedFromCorps extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('corps');
        $table->removeColumn('date_approved');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('corps');
        $table->addColumn('date_approved', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->save();
    }
}

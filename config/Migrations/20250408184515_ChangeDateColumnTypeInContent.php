<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ChangeDateColumnTypeInContent extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('content');
        $table->changeColumn('date', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->save();
    }

    public function down()
    {
        $table = $this->table('content');
        $table->changeColumn('date', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->save();
    }
}

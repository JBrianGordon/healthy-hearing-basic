<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveMicroUrlFromProviders extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('providers');
        $table->removeColumn('micro_url');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('providers');
        $table->addColumn('micro_url', 'string', [
            'default' => null,
            'limit' => 128,
            'null' => true,
            'after' => 'description',
        ]);

        $table->save();
    }
}

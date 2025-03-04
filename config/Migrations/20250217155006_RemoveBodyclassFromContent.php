<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RemoveBodyclassFromContent extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('content');
        $table->removeColumn('bodyclass');
        $table->save();
    }

    public function down()
    {
        $table = $this->table('content');
        $table->addColumn('bodyclass', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => false,
            'after' => 'meta_description',
        ]);

        $table->save();
    }
}

<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddWorkspaceIdToUsers extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table->addColumn('workspace_id', 'string', [
            'default' => null,
            'limit' => 128,
            'collation' => 'utf8mb3_general_ci',
            'null' => true,
            'after' => 'is_superuser',
        ]);
        $table->save();
    }

    public function down()
    {
        $table = $this->table('users');
        $table->removeColumn('workspace_id');
        $table->save();
    }
}
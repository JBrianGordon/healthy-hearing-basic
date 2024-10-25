<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameCallIdInCsCalls extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('cs_calls')
            ->renameColumn('call_id', 'id_callsource_call')
            ->update();
    }
}

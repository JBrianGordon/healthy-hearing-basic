<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateLocationsUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('locations_users');
        $table->addColumn('location_id', 'biginteger', [
            'signed' => false,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'biginteger', [
            'signed' => false,
            'null' => false,
        ]);
        $table->addIndex(['location_id', 'user_id'], ['unique' => true]);
        $table->create();
    }
}

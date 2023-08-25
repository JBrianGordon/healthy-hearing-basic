<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ModifyLocationUserLogins extends AbstractMigration
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
        $this->table('location_user_logins')
            ->addColumn('user_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'after' => 'id'
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->update();

        $this->table('location_user_logins')
            ->rename('login_ips')
            ->update();
    }
}
